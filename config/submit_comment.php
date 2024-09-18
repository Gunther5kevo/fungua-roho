<?php
session_start();
include '../config/server.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $confession_id = $_POST['confession_id'];
    $username = isset($_POST['username']) ? trim($_POST['username']) : 'Unknown';
    $comment_content = isset($_POST['comment_content']) ? trim($_POST['comment_content']) : '';

    // Input validation
    if (!empty($username) && !empty($comment_content)) {
        // Sanitize inputs
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $comment_content = htmlspecialchars($comment_content, ENT_QUOTES, 'UTF-8');

        // Insert the comment into the database
        $stmt = $conn->prepare("INSERT INTO comments (confession_id, username, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $confession_id, $username, $comment_content);
        $stmt->execute();

        // Redirect back to confession page
        header("Location: ../front/confession.php?id=$confession_id");
        exit();
    } else {
        echo "Please enter a username and comment.";
    }
}

