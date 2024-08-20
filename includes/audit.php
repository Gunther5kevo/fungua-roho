<?php
function logAction($admin_id, $action) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO audit_logs (admin_id, action) VALUES (?, ?)");
    $stmt->bind_param('is', $admin_id, $action);
    $stmt->execute();
}

// Example usage
logAction($_SESSION['user_id'], 'Logged in');
