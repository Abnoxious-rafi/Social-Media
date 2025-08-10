<?php
session_start();
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) die("Connection failed");

$followerId = $_SESSION['user_id'];
$followingId = $_POST['following_id'];

if ($followerId != $followingId) {
    $stmt = $conn->prepare("INSERT IGNORE INTO followers (follower_id, following_id, followed_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $followerId, $followingId);
    $stmt->execute();
}

header("Location: friends.php");
exit();
