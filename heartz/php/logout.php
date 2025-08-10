<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session cookie (optional, but more secure)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finally destroy the session
session_destroy();

// Redirect back to login page
header("Location: /heartz/html/login.html");
exit();
