<?php
// like_post.php
// AJAX endpoint to record a “Like” and return the updated count

session_start();
header('Content-Type: application/json');

// 1) Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

// 2) Connect to MySQL
$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'heartz';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed'
    ]);
    exit;
}

// 3) Get & validate inputs
$userId = (int) $_SESSION['user_id'];
$postId = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;

if ($postId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid post ID'
    ]);
    exit;
}

// 4) Check if already liked
$stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?");
$stmt->bind_param("ii", $userId, $postId);
$stmt->execute();
$alreadyLiked = $stmt->get_result()->num_rows > 0;
$stmt->close();

// 5) If not yet liked, insert a new like
if (! $alreadyLiked) {
    $ins = $conn->prepare("
        INSERT INTO likes (user_id, post_id, liked_at)
        VALUES (?, ?, NOW())
    ");
    $ins->bind_param("ii", $userId, $postId);
    $ins->execute();
    $ins->close();
}

// 6) Fetch updated like count
$stmt = $conn->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?");
$stmt->bind_param("i", $postId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$likeCount = (int) $row['like_count'];
$stmt->close();

// 7) Return JSON
echo json_encode([
    'success'    => true,
    'like_count' => $likeCount
]);
