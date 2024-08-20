<?php
include('server.php');
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $categories = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $categories = [];
}
