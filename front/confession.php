<?php
$pageTitle= "Fungua Roho -Confession";
include './includes/header.php';


$id = $_GET['id'];

// Fetch confession
$sql = "SELECT * FROM confessions WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Fetch like/dislike counts
$like_sql = "SELECT likes, dislikes FROM confession_interactions WHERE confession_id = '$id'";
$like_result = $conn->query($like_sql);
$interaction_data = $like_result->fetch_assoc();

$likes = $interaction_data['likes'] ?? 0;
$dislikes = $interaction_data['dislikes'] ?? 0;

// Fetch comments
$comments_sql = "SELECT * FROM comments WHERE confession_id = '$id' ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);
$comments = $comments_result->fetch_all(MYSQLI_ASSOC);

// Fetch tags
$tags_sql = "SELECT name, item_count FROM tags";
$tags_result = $conn->query($tags_sql);
$tags = $tags_result ? $tags_result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch recent comments
$recent_comments_sql = "SELECT * FROM comments ORDER BY created_at DESC LIMIT 5";
$recent_comments_result = $conn->query($recent_comments_sql);
$recent_comments = $recent_comments_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>


 
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <h1 class="my-5"><?php echo htmlspecialchars($row['title']); ?></h1>
                <div class="confession-content">
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                </div>

                <div class="interaction-container">
                    <button class="btn-interaction" id="like-btn">👍</button>
                    <span class="count" id="like-count"><?php echo $likes; ?></span>
                    <button class="btn-interaction" id="dislike-btn">👎</button>
                    <span class="count" id="dislike-count"><?php echo $dislikes; ?></span>
                </div>

                <div class="comment-section mt-5">
                    <h5>Comments:</h5>
                    <textarea id="comment-input" class="comment-input form-control" rows="3"
                        placeholder="Add a comment..."></textarea>
                    <button id="submit-comment" class="btn btn-danger mt-2">Submit Comment</button>

                    <div class="comments-list mt-4">
                        <?php foreach ($comments as $comment): ?>
                        <div class="comment mb-3">
                            <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong></p>
                            <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                            <small
                                class="text-muted"><?php echo date('dS M Y', strtotime($comment['created_at'])); ?></small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
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

    </div>
    </div>
    </div>

<?php include './includes/footer.php';?>