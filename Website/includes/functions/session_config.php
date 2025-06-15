<?php
// Secure session configuration
function secure_session_start()
{
    // Set secure session parameters BEFORE starting the session
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session parameters
        ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookie
        ini_set('session.cookie_secure', 1); // Only send cookie over HTTPS
        ini_set('session.cookie_samesite', 'Strict'); // Prevent CSRF
        ini_set('session.use_only_cookies', 1); // Force session to use cookies
        ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes

        // Set session name
        session_name('SECURE_SESSID');

        // Start the session
        session_start();
    }

    // Initialize session variables if they don't exist
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    }
    if (!isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time();
    }
    if (!isset($_SESSION['created'])) {
        $_SESSION['created'] = time();
    }

    // Regenerate session ID periodically
    $regeneration_time = 30 * 60; // 30 minutes
    if (time() - $_SESSION['last_regeneration'] > $regeneration_time) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }

    // Check session timeout
    $timeout = 30 * 60; // 30 minutes
    if (time() - $_SESSION['last_activity'] > $timeout) {
        // Session has expired
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $_SESSION['last_activity'] = time();
        $_SESSION['last_regeneration'] = time();
        $_SESSION['created'] = time();
    } else {
        $_SESSION['last_activity'] = time();
    }

    // Validate session age
    if (time() - $_SESSION['created'] > 1800) {
        // Session is older than 30 minutes
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}