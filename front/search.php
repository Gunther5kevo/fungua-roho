<?php
include '../config/server.php';

$query = $_GET['query'] ?? '';

if ($query) {
    // Prepare the SQL statement with placeholders to prevent SQL injection
    $sql = "
        SELECT confessions.id, confessions.title, confessions.content, GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags 
        FROM confessions 
        LEFT JOIN confession_tags ON confessions.id = confession_tags.confession_id 
        LEFT JOIN tags ON confession_tags.tag_id = tags.id 
        WHERE confessions.title LIKE ? 
        OR confessions.content LIKE ? 
        OR tags.name LIKE ?
        GROUP BY confessions.id
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters (wildcard search using %)
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all matching confessions
    $confessions = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    $confessions = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fungua Roho - Search Results</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include('header.php'); ?>

    <main class="container">
        <h1 class="text-center my-5">Search Results</h1>

        <section class="search-results">
            <?php if (!empty($confessions)): ?>
                <?php foreach ($confessions as $confession): ?>
                    <div class="confession my-4">
                        <h3><?php echo htmlspecialchars($confession['title']); ?></h3>
                        <p><?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
                        <p><strong>Tags:</strong> <?php echo htmlspecialchars($confession['tags']); ?></p>
                        <a href="confession.php?id=<?php echo $confession['id']; ?>" class="btn btn-link">Read More</a>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No confessions found matching your search criteria.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="text-center mt-5">
        <p>&copy; 2024 Fungua Roho. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
