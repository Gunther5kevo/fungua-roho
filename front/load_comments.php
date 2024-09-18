<?php
include '../config/server.php'; // Your DB connection

$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 5;
$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;

// Query to fetch comments with limit and offset
$query = "SELECT confession_id, username, content, created_at FROM comments ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

// Return the comments as JSON
header('Content-Type: application/json');
echo json_encode($comments);
