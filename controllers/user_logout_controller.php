<?php
    // Unset all session variables
    $_SESSION = array();

    // If the session cookie exists, delete it
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 86400,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        /*setcookie(
            session_name(),
            '',
            [
                'expires' => time() - 86400,
                'path' => '/',
                'domain' => 'pti.unithe.hu',
                'secure' => true, // Secure flag: only send over HTTPS
                'httponly' => true, // HttpOnly flag: JavaScript cannot access the cookie
                'samesite' => 'None',
            ]
        );*/
    }

    // Destroy the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Optionally remove any user-specific cookies
    if (isset($_COOKIE['user_id'])) {
        setcookie(
            'user_id',
            '',
            time() - 86400,
            "/"
        ); // Delete the "user" cookie
        /*setcookie(
            'user_id',
            '',
            [
                'expires' => time() - 86400,
                'path' => '/',
                'domain' => 'pti.unithe.hu',
                'secure' => true, // Secure flag: only send over HTTPS
                'httponly' => true, // HttpOnly flag: JavaScript cannot access the cookie
                'samesite' => 'None',
            ]
        );*/
    }

    $_SESSION['is_logged_in'] = false;

    header('Location: ' . RequestHelper::$url_root . '/' . RequestHelper::$actor_name . '/login');
    exit();

?>