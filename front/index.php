<?php
include('header.php');
include '../config/fetch.php';

// Fetch random confessions with tags
$random_confessions_sql = "SELECT confessions.id, confessions.title, confessions.content, categories.name, GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags 
                           FROM confessions 
                           JOIN categories ON confessions.category_id = categories.id 
                           LEFT JOIN confession_tags ON confessions.id = confession_tags.confession_id 
                           LEFT JOIN tags ON confession_tags.tag_id = tags.id 
                           GROUP BY confessions.id 
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
    <meta name="description" content="Explore confessions on love, family, deep secrets, and more.">
    <meta name="keywords" content="confessions, love, secrets, family, Fungua Roho">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    

    <!-- Full-Width Search Bar -->
    <section class="search-bar-tab bg-light py-3">
        <div class="container">
            <form action="search.php" method="GET" class="form-inline w-100">
                <input type="text" name="query" class="form-control "
                    placeholder="Search confessions by tags or keywords" required>
                <button type="submit" class="btn btn-danger btn-lg">Search</button>
            </form>
        </div>
    </section>

    <main class="container mt-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <h1 class="text-center mb-5">Welcome to Fungua Roho</h1>

                <!-- Random Confessions -->
                <section class="random-confessions mb-5">
                    <h2 class="text-center mb-4">Nafungua Roho</h2>
                    <div class="row">
                        <?php foreach ($random_confessions as $confession): ?>
                        <div class="col-md-12 mb-4">
                            <div class="confession">
                                <h3><?php echo htmlspecialchars($confession['title']); ?></h3>
                                <p><?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
                                <p><strong>Tags:</strong> <?php echo htmlspecialchars($confession['tags']); ?></p>
                                <a href="confession.php?id=<?php echo $confession['id']; ?>" class="btn btn-link">Read
                                    More</a>
                                <div class="like-dislike-container mt-2">
                                    <button class="btn btn-link">👍</button>
                                    <button class="btn btn-link">👎</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <!-- Tag Cloud -->
                <div class="tagcloud mb-4">
                    <h5>Tags</h5>
                    <?php foreach ($tags as $tag): ?>
                    <?php
                        // Calculate font size based on item count
                        $fontSize = 10 + ($tag['item_count'] / 10); // Example scaling
                    ?>
                    <a href="tag.php?tag=<?php echo urlencode($tag['name']); ?>" class="tag-cloud-link"
                        style="font-size: <?php echo $fontSize; ?>pt;"
                        aria-label="<?php echo htmlspecialchars($tag['name']); ?> (<?php echo $tag['item_count']; ?> items)">
                        <?php echo htmlspecialchars($tag['name']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Recent Comments -->
                <div class="recent-comments-section mb-4">
                    <h5>Recent Comments</h5>
                    <ul class="list-group">
                        <?php foreach ($recent_comments as $comment): ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                            <p><?php echo htmlspecialchars(substr($comment['content'], 0, 50)) . '...'; ?></p>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center mt-5">
        <p>&copy; 2024 Fungua Roho. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
