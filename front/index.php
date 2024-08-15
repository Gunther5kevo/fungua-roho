<?php
include '../config/server.php';

// Fetch categories
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

// Fetch random confessions
$random_confessions_sql = "SELECT confessions.id, confessions.title, confessions.content, categories.name 
                           FROM confessions 
                           JOIN categories ON confessions.category_id = categories.id 
                           ORDER BY RAND() LIMIT 3";
$random_confessions_result = $conn->query($random_confessions_sql);

$random_confessions = $random_confessions_result ? $random_confessions_result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fungua Roho - Home</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include('header.php'); ?>

    <main class="container">
        <h1 class="text-center my-5">Welcome to Fungua Roho</h1>
        <section class="categories my-5">
            <h2 class="text-center mb-4">Explore Categories</h2>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text">Confessions about
                                <?php echo strtolower(htmlspecialchars($category['name'])); ?>.</p>
                            <a href="category.php?category=<?php echo urlencode($category['name']); ?>"
                                class="btn btn-danger">Explore</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>


        <section class="random-confessions my-5">
            <h2 class="text-center mb-4">Be Free</h2>
            <div class="row">
                <?php foreach ($random_confessions as $confession): ?>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($confession['title']); ?></h5>
                            <p class="card-text">
                                <?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
                            <a href="category.php?category=<?php echo urlencode($confession['name']); ?>"
                                class="btn btn-danger">Explore <?php echo htmlspecialchars($confession['name']); ?></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
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