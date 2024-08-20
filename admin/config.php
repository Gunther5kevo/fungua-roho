<?php
// Set session save path to a valid directory
$session_save_path = 'C:/xampp/tmp'; // Default temp path for XAMPP on Windows
if (!is_dir($session_save_path)) {
    mkdir($session_save_path, 0777, true); // Create the directory if it doesn't exist
}
session_save_path($session_save_path);

// Set session name before starting the session
session_name('admin_session');

// Start the session with secure settings
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => false, // Set to true if using HTTPS
    'cookie_httponly' => true,
    'use_strict_mode' => true,
    'use_only_cookies' => true,
    'use_trans_sid' => false,
]);

// Check if the session started successfully
if (session_status() !== PHP_SESSION_ACTIVE) {
    die('Failed to start session');
}

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Ensure proper session expiry
$timeout_duration = 1800;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity

// Database connection
include '../config/server.php';
