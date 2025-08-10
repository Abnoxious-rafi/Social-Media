<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['user'])) {
    echo json_encode(['success' => false, 'messages' => []]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit();
}

$currentUserId = $_SESSION['user_id'];
$receiverId = (int)$_GET['user'];

$stmt = $conn->prepare("
    SELECT * FROM messages
    WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
    ORDER BY sent_at ASC
");
$stmt->bind_param("iiii", $currentUserId, $receiverId, $receiverId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'sender_id' => $row['sender_id'],
        'message_text' => htmlspecialchars($row['message_text']),
        'sent_at' => $row['sent_at']
    ];
}

echo json_encode(['success' => true, 'messages' => $messages]);
