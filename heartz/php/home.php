<?php
// ┌───────────────────────────────────────────────────────────────────────────┐
// │ 1) Session + Auth check                                                │
// └───────────────────────────────────────────────────────────────────────────┘
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['email'])) {
    header("Location: /heartz/heartz/login.html");
    exit();
}
$currentUserId   = (int) $_SESSION['user_id'];
$currentUsername = htmlspecialchars($_SESSION['username']);

// ┌───────────────────────────────────────────────────────────────────────────┐
// │ 2) Database connection                                                  │
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ┌───────────────────────────────────────────────────────────────────────────┐
// │ 3) Build list of IDs you’re following                                   │
$followingIds = [];
$stmt = $conn->prepare("SELECT following_id FROM followers WHERE follower_id = ?");
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $followingIds[] = (int)$row['following_id'];
}
$stmt->close();

// ┌───────────────────────────────────────────────────────────────────────────┐
// │ 4) Fetch up to 30 freshest posts FROM your followings                   │
$posts = [];
if (count($followingIds) > 0) {
    $in  = implode(",", $followingIds);
    $sql = "
    SELECT p.*, u.username, u.profile_pic
    FROM posts AS p
    JOIN users AS u ON p.user_id = u.user_id
    WHERE p.user_id IN ($in)
    ORDER BY p.created_at DESC
    LIMIT 30
    ";
    $result = $conn->query($sql);
    while ($r = $result->fetch_assoc()) {
        $posts[] = $r;
    }
}

// ┌───────────────────────────────────────────────────────────────────────────┐
// │ 5) If fewer than 10, backfill with RANDOM posts                        │
if (count($posts) < 10) {
    $needed = 10 - count($posts);
    $sql    = "
    SELECT p.*, u.username, u.profile_pic
    FROM posts AS p
    JOIN users AS u ON p.user_id = u.user_id
    ORDER BY RAND()
    LIMIT $needed
    ";
    $result = $conn->query($sql);
    while ($r = $result->fetch_assoc()) {
        $posts[] = $r;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/heartz/css/home.css">
    <title>Home - Heartz</title>
</head>

<body>

    <header class="fb-header">
        <a href="/heartz/php/home.php" style="text-decoration: none;">
            <div class="fb-logo">
                <img
                    src="/heartz/files/images/logo.png"
                    alt="Heartz logo"
                    class="fb-logo-img">
                <span class="fb-logo-text">eartz</span>
            </div>
        </a>
        <div class="fb-search">
            <input type="text" placeholder="Search Heartz">
        </div>
        <div class="fb-nav">
            <form action="/heartz/php/home.php" method="GET" class="nav-form">
                <button type="submit" class="nav-btn">Home</button>
            </form>
            <form action="/heartz/php/message.php" method="POST" class="logout-form">
                <button type="submit">Message</button>
            </form>
            <form action="/heartz/php/friends.php" method="GET" class="nav-form">
                <button type="submit" class="nav-btn">Friends</button>
            </form>
            <form action="/heartz/php/comming_soon.php" method="GET" class="nav-form">
                <button type="submit" class="nav-btn">Notifications</button>
            </form>
            <!-- profile -->
            <form action="/heartz/php/profile.php" method="GET" class="nav-form">
                <!-- no id= means it loads the current user’s profile -->
                <button type="submit" class="nav-btn">Profile</button>
            </form>

            <form action="/heartz/php/logout.php" method="POST" class="logout-form">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <div class="fb-container">
        <!-- Create Post Box -->
        <div class="fb-post-box">
            <form action="/heartz/php/create_post.php" method="POST" enctype="multipart/form-data" class="fb-post-actions">
                <div class="fb-post-header">
                    <a href="/heartz/php/profile.php" class="fb-avatar-link">
                        <img
                            src="/heartz/php/<?php echo htmlspecialchars($_SESSION['profile_pic'] ?? 'files/images/default_man.png'); ?>"
                            class="fb-avatar"
                            alt="Your avatar" />
                    </a>
                    <textarea
                        name="post_text"
                        placeholder="What's on your mind, <?= $currentUsername ?>?"
                        required></textarea>
                </div>

                <div class="fb-post-options">
                    <label class="option photo-upload">
                        <span class="icon">✨</span><span>Photo/Feelings</span>
                        <input type="file" name="media_file" accept="image/*,video/*" id="mediaFileInput">
                    </label>
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>

        <!-- Feed -->
        <div class="fb-feed">
            <?php foreach ($posts as $post): ?>
                <div class="fb-post-card">
                    <!-- Post Header -->
                    <div class="post-top">
                        <a
                            href="/heartz/php/profile.php?id=<?= (int)$post['user_id'] ?>"
                            class="fb-avatar-link"
                            title="View <?= htmlspecialchars($post['username']) ?>’s profile">
                            <img
                                src="/heartz/php/<?= htmlspecialchars($post['profile_pic'] ?: 'files/images/default_man.png') ?>"
                                class="fb-avatar-small"
                                alt="<?= htmlspecialchars($post['username']) ?>'s avatar" />
                        </a>
                        <div class="post-user">
                            <strong><?= htmlspecialchars($post['username']) ?></strong><br>
                            <span class="post-time"><?= htmlspecialchars($post['created_at']) ?></span>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                    </div>

                    <!-- Post Media -->
                    <?php if (!empty($post['image_url'])): ?>
                        <div class="post-media">
                            <?php $ext = strtolower(pathinfo($post['image_url'], PATHINFO_EXTENSION)); ?>
                            <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                <img loading="lazy"
                                    src="/heartz/php/<?= htmlspecialchars($post['image_url']) ?>"
                                    alt="Post image">
                            <?php else: ?>
                                <video controls preload="none">
                                    <source src="/heartz/php/<?= htmlspecialchars($post['image_url']) ?>">
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Compute like count and whether current user liked -->
                    <?php
                    // like count
                    $stmt = $conn->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?");
                    $stmt->bind_param("i", $post['post_id']);
                    $stmt->execute();
                    $likeCount = $stmt->get_result()->fetch_assoc()['like_count'];
                    $stmt->close();
                    // check if liked
                    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?");
                    $stmt->bind_param("ii", $_SESSION['user_id'], $post['post_id']);
                    $stmt->execute();
                    $isLiked = $stmt->get_result()->num_rows > 0;
                    $stmt->close();
                    ?>

                    <!-- Reactions -->
                    <div class="post-reactions">
                        <button class="like-btn <?= $isLiked ? 'liked' : '' ?>"
                            data-post-id="<?= $post['post_id'] ?>">
                            Like <span class="like-count"><?= $likeCount ?></span>
                        </button>
                        <button type="button" onclick="window.location.href='/heartz/php/comming_soon.php';">Comment</button>
                        <button type="button" onclick="window.location.href='/heartz/php/comming_soon.php';">🔗Share</button>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>


    </div>

    <script>
        const input = document.getElementById('mediaFileInput');
        const label = input.closest('.photo-upload');

        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                label.classList.add('selected');
            } else {
                label.classList.remove('selected');
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const likeCountElem = this.querySelector('.like-count');

                    fetch('/heartz/php/like_post.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'post_id=' + encodeURIComponent(postId)
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Request failed');
                            return response.json(); // Expect JSON response
                        })
                        .then(data => {
                            if (data.success) {
                                likeCountElem.textContent = `${data.like_count}`;
                            } else {
                                alert(data.message || 'Already liked or error');
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                        });
                });
            });
        });
    </script>

</body>

</html>