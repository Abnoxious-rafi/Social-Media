<?php
session_start();
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) die("Connection failed");
// Logged-in user ID
$currentUserId = $_SESSION['user_id'] ?? 0;

// --- Handle Pagination ---
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// --- Handle Search ---
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$searchQuery = $search ? "%$search%" : "%";

// --- Total users for pagination ---
$countStmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE user_id != ? AND username LIKE ?");
$countStmt->bind_param("is", $currentUserId, $searchQuery);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalUsers = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalUsers / $limit);

// --- Get users with pagination + search ---
$stmt = $conn->prepare("SELECT user_id, username, profile_pic FROM users WHERE user_id != ? AND username LIKE ? ORDER BY username ASC LIMIT ?, ?");
$stmt->bind_param("isii", $currentUserId, $searchQuery, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// --- Get following list of logged-in user ---
$followStmt = $conn->prepare("SELECT following_id FROM followers WHERE follower_id = ?");
$followStmt->bind_param("i", $currentUserId);
$followStmt->execute();
$followResult = $followStmt->get_result();
$followingList = [];
while ($row = $followResult->fetch_assoc()) {
    $followingList[] = $row['following_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Friends</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/heartz/css/friends.css">
</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>
    <div class="main_bod">
        <!-- Search Form -->
        <form method="GET" action="/heartz/php/friends.php" class="search-form">
            <input type="text" name="search" placeholder="Search friends"
                value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Grid of Friend Cards -->
        <div class="friend-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="friend-card">
                    <img
                        src="/heartz/php/<?= htmlspecialchars($row['profile_pic'] ?: 'default.png') ?>"
                        alt="<?= htmlspecialchars($row['username']) ?>"
                        class="friend-avatar">
                    <div class="friend-name">
                        <?= htmlspecialchars($row['username']) ?>
                    </div>
                    <div class="friend-action">
                        <?php if (in_array($row['user_id'], $followingList)): ?>
                            <form action="/heartz/php/unfollow.php" method="POST">
                                <input type="hidden" name="following_id" value="<?= $row['user_id'] ?>">
                                <button type="submit" class="btn unfollow">Unfollow</button>
                            </form>
                        <?php else: ?>
                            <form action="/heartz/php/follow.php" method="POST">
                                <input type="hidden" name="following_id" value="<?= $row['user_id'] ?>">
                                <button type="submit" class="btn follow">Follow</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="<?= $i == $page ? 'active' : '' ?>"
                    href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>