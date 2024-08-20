<?php
include 'server.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confession_id = $_POST['confession_id'];
    $content = trim($_POST['content']);
    $username = 'Anonymous'; // Default username; you can replace this with actual user data if available

    if (empty($content)) {
        echo json_encode(['error' => 'Comment cannot be empty.']);
        exit;
    }

    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (confession_id, username, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $confession_id, $username, $content);

    if ($stmt->execute()) {
        $comment_id = $stmt->insert_id;

        // Fetch the newly inserted comment for response
        $comment_sql = "SELECT username, content, created_at FROM comments WHERE id = ?";
        $comment_stmt = $conn->prepare($comment_sql);
        $comment_stmt->bind_param("i", $comment_id);
        $comment_stmt->execute();
        $result = $comment_stmt->get_result();
        $comment = $result->fetch_assoc();

        // Format the created_at date
        $comment['created_at'] = date('dS M Y', strtotime($comment['created_at']));

        echo json_encode($comment);
    } else {
        echo json_encode(['error' => 'Failed to submit comment. Please try again.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
