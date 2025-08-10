<?php
// Start session
session_start();

// DB credentials
$host     = "localhost";
$dbUser   = "root";    // default XAMPP
$dbPass   = "";        // default XAMPP
$dbName   = "heartz";  // your database name

// Connect to database
$conn = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values (and trim to be safe)
$emailInput = trim($_POST['email']);
$passInput  = trim($_POST['password']);

// 1) Fetch the stored hash and user_id for this email
$stmt = $conn->prepare("SELECT user_id, password_hash,username,profile_pic FROM users WHERE email = ?");
$stmt->bind_param("s", $emailInput);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row        = $result->fetch_assoc();
    $storedHash = $row['password_hash'];
    $userId     = $row['user_id'];
    $username = $row['username'];
    $profilepc = $row['profile_pic'] ?: 'files/images/default_man.png';

    // 2) Verify the submitted password against the stored hash
    if (password_verify($passInput, $storedHash)) {
        // ✅ Password is correct: log the user in
        $_SESSION['email']   = $emailInput;
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['profile_pic'] = $profilepc;

        header("Location: /heartz/php/home.php");
        exit();
    }
}

// If we reach here, either email not found or password wrong
echo "Invalid email or password.";

$stmt->close();
$conn->close();
