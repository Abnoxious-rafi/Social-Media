<?php
$host = "localhost";
$dbname = "heartz";
$db_user = "root";
$db_pass = "";

$conn = new mysqli($host, $db_user, $db_pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$username = $_POST['username'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$bio      = isset($_POST['bio']) ? $_POST['bio'] : NULL;

// Handle profile picture upload
$profile_pic_path = NULL;
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
  // **Removed leading slash** so this is a web‑relative folder
  $target_dir = "files/images/";

  // Create folder if it doesn't exist
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
  }

  // Count number of existing image files
  $existing_images = glob($target_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
  $image_count = count($existing_images) + 1;

  // Get uploaded file extension
  $imageFileType = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));

  // Validate extension
  $allowed = ['jpg', 'jpeg', 'png', 'gif'];
  if (!in_array($imageFileType, $allowed)) {
    die("Only JPG, JPEG, PNG, and GIF files are allowed.");
  }

  // Rename file to e.g., heartz/files/images/5.jpg
  $new_filename = $image_count . "." . $imageFileType;
  $target_file = $target_dir . $new_filename;

  // Move file to target folder
  if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
    $profile_pic_path = $target_file;
  } else {
    die("Error uploading file.");
  }
}

// Prepare and execute insert
$stmt = $conn->prepare(
  "INSERT INTO users (username, email, password_hash, bio, profile_pic) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("sssss", $username, $email, $password, $bio, $profile_pic_path);

if ($stmt->execute()) {
  echo "User registered successfully!";
  header("Location: /heartz/html/login.html");
  exit();
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
