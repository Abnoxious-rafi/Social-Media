<?php
// ┌───────────────────────────────────────────────────────────────────────────┐
// │ Profile Page for Heartz                                                    │
// └───────────────────────────────────────────────────────────────────────────┘
session_start();
// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'], $_SESSION['email'])) {
    header("Location: /heartz/heartz/login.html");
    exit();
}
// Determine which profile to show: GET ?id= or current user
$currentUserId = (int) $_SESSION['user_id'];
$profileUserId = isset($_GET['id']) ? (int)$_GET['id'] : $currentUserId;

// DB connection
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch user info
$stmt = $conn->prepare("SELECT user_id, username, email, profile_pic, created_at FROM users WHERE user_id = ?");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user) {
    echo "<p>User not found.</p>";
    exit();
}

// Count stats: posts, followers, following
// Posts count
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM posts WHERE user_id = ?");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$postsCount = $stmt->get_result()->fetch_assoc()['cnt'];
$stmt->close();
// Followers count
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM followers WHERE following_id = ?");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$followersCount = $stmt->get_result()->fetch_assoc()['cnt'];
$stmt->close();
// Following count
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM followers WHERE follower_id = ?");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$followingCount = $stmt->get_result()->fetch_assoc()['cnt'];
$stmt->close();

// Check follow status if viewing another profile
$isFollowing = false;
if ($profileUserId !== $currentUserId) {
    $stmt = $conn->prepare("SELECT 1 FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->bind_param("ii", $currentUserId, $profileUserId);
    $stmt->execute();
    $isFollowing = $stmt->get_result()->num_rows > 0;
    $stmt->close();
}

// Fetch user's posts
$stmt = $conn->prepare("SELECT p.*, u.username, u.profile_pic
                      FROM posts p
                      JOIN users u ON p.user_id = u.user_id
                      WHERE p.user_id = ?
                      ORDER BY p.created_at DESC");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$posts = [];
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $posts[] = $row;
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/heartz/css/profile.css">
    <title><?= htmlspecialchars($user['username']) ?> | Heartz</title>
</head>

<body>
    <div class="profile_heder">
        <?php include 'header.php'; ?>
    </div>
    <div class="profile-container">
        <div class="profile-header">
            <img src="/heartz/php/<?= htmlspecialchars($user['profile_pic'] ?: 'files/images/default_man.png') ?>" class="profile-avatar" alt="Avatar">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <p>Joined on <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
            <div class="profile-stats">
                <span><strong><?= $postsCount ?></strong> Posts</span>
                <span><strong><?= $followersCount ?></strong> Followers</span>
                <span><strong><?= $followingCount ?></strong> Following</span>
            </div>
            <?php if ($profileUserId !== $currentUserId): ?>
                <form action="/heartz/php/follow_action.php" method="POST">
                    <input type="hidden" name="target_id" value="<?= $profileUserId ?>">
                    <button type="submit"><?= $isFollowing ? 'Unfollow' : 'Follow' ?></button>
                </form>
            <?php endif; ?>
        </div>
        <hr>
        <div class="profile-posts">
            <?php if (empty($posts)): ?>
                <p>No posts yet.</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-top">
                            <img src="/heartz/php/<?= htmlspecialchars($post['profile_pic'] ?: 'files/images/default_man.png') ?>" class="avatar-small">
                            <div>
                                <strong><?= htmlspecialchars($post['username']) ?></strong>
                                <span><?= htmlspecialchars($post['created_at']) ?></span>
                            </div>
                        </div>
                        <div class="post-content">
                            <?= nl2br(htmlspecialchars($post['content'])) ?>
                        </div>
                        <?php if (!empty($post['image_url'])): ?>
                            <div class="post-media">
                                <?php $ext = strtolower(pathinfo($post['image_url'], PATHINFO_EXTENSION)); ?>
                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img src="/heartz/php/<?= htmlspecialchars($post['image_url']) ?>" loading="lazy">
                                <?php else: ?>
                                    <video controls preload="none">
                                        <source src="/heartz/php/<?= htmlspecialchars($post['image_url']) ?>">
                                    </video>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>