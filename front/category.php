<?php
$current_category = isset($_GET['category']) ? urldecode($_GET['category']) : '';
$pageTitle = 'Fungua Roho - ' . htmlspecialchars($current_category);

include './includes/header.php';

// Capture the category from the URL parameter


// Define the page title, meta description, and keywords specific to this page

$metaDescription = "Explore confessions in the " . htmlspecialchars($current_category) . " category.";
$metaKeywords = "confessions, " . htmlspecialchars($current_category) . ", secrets, Fungua Roho";

// Fetch confessions for the selected category
$confessions_sql = "SELECT confessions.id, confessions.title, confessions.content, categories.name, GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags 
                    FROM confessions 
                    JOIN categories ON confessions.category_id = categories.id 
                    LEFT JOIN confession_tags ON confessions.id = confession_tags.confession_id 
                    LEFT JOIN tags ON confession_tags.tag_id = tags.id 
                    WHERE categories.name = ?
                    GROUP BY confessions.id 
                    ORDER BY RAND() LIMIT 3";

$stmt = $conn->prepare($confessions_sql);
$stmt->bind_param('s', $current_category);
$stmt->execute();
$result = $stmt->get_result();

$confessions = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();


?>

<section class="search-bar-tab bg-light py-3 my-4">
    < <div class="container">
        <form action="search.php" method="GET" class="form-inline w-100">
            <input type="text" name="query" class="form-control search-input"
                placeholder="Search confessions by tags or keywords" required>
            <button type="submit" class="btn search-btn">Search</button>
        </form>
        </div>
</section>

<main class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <h1 class="text-center mb-5"><?php echo htmlspecialchars($current_category); ?></h1>

            <!-- Category Confessions -->
            <section class="category-confessions mb-5">
                <div class="row">
                    <?php if (!empty($confessions)): ?>
                    <?php foreach ($confessions as $confession): ?>
                    <div class="col-md-12 mb-4">
                        <div class="confession">
                            <h3><?php echo htmlspecialchars($confession['title']); ?></h3>
                            <p><?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
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
                    <?php else: ?>
                    <p class="text-center">No confessions found in this category.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>

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

<?php include './includes/footer.php'; ?>