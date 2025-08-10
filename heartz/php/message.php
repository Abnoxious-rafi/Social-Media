<!-- File: message.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /heartz/index.html");
    exit();
}
$conn = new mysqli("localhost", "root", "", "heartz");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$currentUserId = $_SESSION['user_id'];
$receiverId = isset($_GET['user']) ? (int)$_GET['user'] : 0;

$followQuery = $conn->prepare("
    SELECT u.user_id, u.username, u.profile_pic
    FROM followers f
    JOIN users u ON f.following_id = u.user_id
    WHERE f.follower_id = ?
");
$followQuery->bind_param("i", $currentUserId);
$followQuery->execute();
$followingUsers = $followQuery->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $receiverId && isset($_POST['message_text'])) {
    $text = trim($_POST['message_text']);
    if ($text !== '') {
        $sendQuery = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)");
        $sendQuery->bind_param("iis", $currentUserId, $receiverId, $text);
        $sendQuery->execute();
    }
}

$messages = [];
if ($receiverId) {
    $msgQuery = $conn->prepare("
        SELECT * FROM messages
        WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        ORDER BY sent_at ASC
    ");
    $msgQuery->bind_param("iiii", $currentUserId, $receiverId, $receiverId, $currentUserId);
    $msgQuery->execute();
    $messages = $msgQuery->get_result();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Heartz Messenger</title>
    <link rel="stylesheet" href="/heartz/css/messenger.css">
</head>

<body>
    <header class="fb-header">
        <a href="/heartz/php/home.php" class="fb-logo" style="text-decoration: none;">
            <img src="/heartz/files/images/logo.png" alt="Heartz logo" class="fb-logo-img">
            <span class="fb-logo-text">EARTZ</span>
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
            <form action="/heartz/php/logout.php" method="POST" class="logout-form">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <div class="sidebar">
        <h3>Following</h3>
        <?php foreach ($followingUsers as $user): ?>
            <div class="user-link">
                <a href="message.php?user=<?= $user['user_id'] ?>">
                    <img src="/heartz/php/<?= $user['profile_pic'] ?>" class="user-pic">
                    <span><?= htmlspecialchars($user['username']) ?></span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const selUserId = params.get('user'); // the ?user=XXX from URL
            const links = document.querySelectorAll('.sidebar .user-link');

            links.forEach(linkContainer => {
                const a = linkContainer.querySelector('a');
                const url = new URL(a.href, window.location.origin);
                const userId = url.searchParams.get('user');

                // On page load: highlight the one matching URL
                if (userId === selUserId) {
                    linkContainer.classList.add('active');
                }

                // On click: clear old, highlight new, then navigate
                linkContainer.addEventListener('click', e => {
                    e.preventDefault();
                    links.forEach(lc => lc.classList.remove('active'));
                    linkContainer.classList.add('active');
                    // finally go to the new URL
                    window.location.href = a.href;
                });
            });
        });
    </script>


    <div class="chat-container">
        <?php if ($receiverId): ?>
            <div class="chat-window" id="chatWindow"></div>
            <script>
                const currentUserId = <?= json_encode($currentUserId) ?>;
                const receiverId = <?= json_encode($receiverId) ?>;
                const chatWindow = document.getElementById('chatWindow');

                function loadMessages() {
                    fetch(`/heartz/php/fetch_messages.php?user=${receiverId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                chatWindow.innerHTML = '';
                                data.messages.forEach(msg => {
                                    const div = document.createElement('div');
                                    div.classList.add('message', msg.sender_id == currentUserId ? 'sent' : 'received');
                                    div.innerHTML = `${msg.message_text}<br><small>${msg.sent_at}</small>`;
                                    chatWindow.appendChild(div);
                                });
                                chatWindow.scrollTop = chatWindow.scrollHeight;
                            }
                        })
                        .catch(err => console.error('Fetch error:', err));
                }
                setInterval(loadMessages, 2000);
                loadMessages();
            </script>

            <form method="POST" class="input-box">
                <textarea name="message_text" placeholder="Type a message..." required></textarea>
                <button type="submit">Send</button>
            </form>
        <?php else: ?>
            <div class="no-user">Select a user to start chatting....!</div>
        <?php endif; ?>
    </div>
</body>

</html>