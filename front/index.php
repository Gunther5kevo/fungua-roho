<?php

include('./includes/header.php');


// Fetch random confessions
$random_confessions_sql = "SELECT confessions.id, confessions.title, confessions.content, categories.name, GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags 
                            FROM confessions 
                            JOIN categories ON confessions.category_id = categories.id 
                            LEFT JOIN confession_tags ON confessions.id = confession_tags.confession_id 
                            LEFT JOIN tags ON confession_tags.tag_id = tags.id 
                            GROUP BY confessions.id 
                            ORDER BY RAND() LIMIT 3";

$result = $conn->query($random_confessions_sql);
$random_confessions = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];




?>
<?= alertMessage(); ?>
<section class="search-bar-tab bg-light py-3 my-4">
    <div class="container">
        <form action="search.php" method="GET" class="form-inline w-100">
            <input type="text" name="query" class="form-control search-input"
                placeholder="Search confessions by tags or keywords" required>
            <button type="submit" class="btn search-btn">Search</button>
        </form>
    </div>
</section>

<main class="container mt-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12 col-md-8">
            <h1 class="text-center mb-4">Welcome to Fungua Roho</h1>
            <!-- Random Confessions -->
            <section class="random-confessions mb-4">
                <div class="row">
                    <?php foreach ($random_confessions as $confession): ?>
                    <div class="col-12 mb-3">
                        <div class="confession">
                            <h3><?php echo htmlspecialchars($confession['title']); ?></h3>
                            <p><?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
                            <a href="confession.php?id=<?php echo $confession['id']; ?>" class="btn btn-link">Read
                                More</a>
                            
                        </div>
                        <hr>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-md-4">
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
            <?php include 'recent_comments.php';?>
        </div>
    </div>
</main>

<?php include './includes/footer.php';?>