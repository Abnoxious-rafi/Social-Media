<?php
session_start();  // ← make sure you have this to access user_id
$host    = "localhost";
$dbuser  = "root";
$dbpass  = "";
$dbname  = "heartz";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];   // ← current user’s ID
$content = $_POST['post_text'] ?? '';

// Handle optional upload
$image_url = NULL;
if (!empty($_FILES['media_file']['tmp_name']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "files/images/";  // your existing folder

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // count existing files (images & videos)
    $existing = glob($target_dir . "*.{jpg,jpeg,png,gif,mp4,mov,avi,mkv}", GLOB_BRACE);
    $next     = count($existing) + 1;

    $ext = strtolower(pathinfo($_FILES['media_file']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'mkv'];
    if (!in_array($ext, $allowed, true)) {
        die("Only JPG, JPEG, PNG, GIF, MP4, MOV, AVI & MKV are allowed.");
    }

    $newName = $next . "." . $ext;
    $dest    = $target_dir . $newName;

    if (!move_uploaded_file($_FILES['media_file']['tmp_name'], $dest)) {
        die("Error uploading file.");
    }

    // this goes into your image_url column
    $image_url = $dest;
}

// Insert into posts
$stmt = $conn->prepare(
    "INSERT INTO posts (user_id, content, image_url, created_at)
     VALUES (?, ?, ?, NOW())"
);
$stmt->bind_param("iss", $user_id, $content, $image_url);

if ($stmt->execute()) {
    header("Location: home.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
