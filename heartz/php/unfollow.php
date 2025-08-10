<?php
session_start();
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) die("Connection failed");

$followerId = $_SESSION['user_id'];
$followingId = $_POST['following_id'];

$stmt = $conn->prepare("DELETE FROM followers WHERE follower_id = ? AND following_id = ?");
$stmt->bind_param("ii", $followerId, $followingId);
$stmt->execute();

header("Location: friends.php");
exit();
