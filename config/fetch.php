<?php
include'server.php';
// Fetch tags
$tags_sql = "SELECT name, item_count FROM tags";
$tags_result = $conn->query($tags_sql);
$tags = $tags_result ? $tags_result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch recent comments
$recent_comments_sql = "SELECT * FROM comments ORDER BY created_at DESC LIMIT 5";
$recent_comments_result = $conn->query($recent_comments_sql);
$recent_comments = $recent_comments_result->fetch_all(MYSQLI_ASSOC);


