<?php
include 'server.php';

if (isset($_POST['confession_id']) && isset($_POST['type'])) {
    $confession_id = intval($_POST['confession_id']);
    $type = $_POST['type'];

    // Check if confession_id exists in confession_interactions
    $check_sql = "SELECT * FROM confession_interactions WHERE confession_id = '$confession_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 0) {
        // Insert a new row if it doesn't exist
        $insert_sql = "INSERT INTO confession_interactions (confession_id, likes, dislikes) VALUES ('$confession_id', 0, 0)";
        $conn->query($insert_sql);
    }

    // Update the likes or dislikes based on the type
    if ($type == 'like') {
        $update_sql = "UPDATE confession_interactions SET likes = likes + 1 WHERE confession_id = '$confession_id'";
    } elseif ($type == 'dislike') {
        $update_sql = "UPDATE confession_interactions SET dislikes = dislikes + 1 WHERE confession_id = '$confession_id'";
    }

    if ($conn->query($update_sql) === TRUE) {
        $get_counts_sql = "SELECT likes, dislikes FROM confession_interactions WHERE confession_id = '$confession_id'";
        $result = $conn->query($get_counts_sql);
        $data = $result->fetch_assoc();

        echo json_encode(['likes' => $data['likes'], 'dislikes' => $data['dislikes']]);
    } else {
        echo json_encode(['error' => 'Failed to update interactions']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
