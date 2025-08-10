
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/heartz/css/home.css">
    <!-- <link rel="stylesheet" href="/heartz/css/profile.css"> -->
    <title>Heartz</title>
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