<?php
include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user input for security
    $title = $_POST['title'];
    $category_name = $_POST['category'];
    $content = $_POST['content'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $category_row = $result->fetch_assoc();
    $category_id = $category_row['id'];

    // Insert confession
    $stmt = $conn->prepare("INSERT INTO confessions (title, category_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $title, $category_id, $content);

    if ($stmt->execute()) {
        $message = "New confession submitted successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    // Use JavaScript to alert the message and redirect
    echo "<script>
        alert('$message');
        window.location.href = '../front/submit.php'; 
    </script>";
}
