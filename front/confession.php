<?php
$pageTitle = "Speak Your Heart - Confession Details";
include './includes/header.php';

$id = $_GET['id'];

// Fetch confession
$stmt = $conn->prepare("SELECT * FROM confessions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch like/dislike counts
$like_stmt = $conn->prepare("SELECT likes, dislikes FROM confession_interactions WHERE confession_id = ?");
$like_stmt->bind_param("i", $id);
$like_stmt->execute();
$like_result = $like_stmt->get_result();
$interaction_data = $like_result->fetch_assoc();

$likes = $interaction_data['likes'] ?? 0;
$dislikes = $interaction_data['dislikes'] ?? 0;

// Fetch comments
$comments_stmt = $conn->prepare("SELECT * FROM comments WHERE confession_id = ? ORDER BY created_at DESC");
$comments_stmt->bind_param("i", $id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();
$comments = $comments_result->fetch_all(MYSQLI_ASSOC);

// Fetch tags
$tags_stmt = $conn->prepare("SELECT name, item_count FROM tags");
$tags_stmt->execute();
$tags_result = $tags_stmt->get_result();
$tags = $tags_result ? $tags_result->fetch_all(MYSQLI_ASSOC) : [];

// Fetch recent comments
$recent_comments_stmt = $conn->prepare("SELECT * FROM comments ORDER BY created_at DESC LIMIT 5");
$recent_comments_stmt->execute();
$recent_comments_result = $recent_comments_stmt->get_result();
$recent_comments = $recent_comments_result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <h1 class="my-4" style="font-size: 22px;"><?php echo htmlspecialchars($row['title']); ?></h1>
            <div class="confession-content">
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <p class="text-muted">- Shared anonymously</p>
            </div>



            <div class="comment-section mt-5">
                <h5>Comments:</h5>
                <form id="comment-form" action="../config/submit_comment.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Enter your username"
                            required>
                    </div>
                    <textarea id="comment-input" name="comment_content" class="comment-input form-control" rows="3"
                        placeholder="Add a comment..." required></textarea>
                    <small class="text-muted">Your username will be visible with your comment</small>
                    <input type="hidden" name="confession_id" value="<?php echo $id; ?>">
                    <button id="submit-comment" type="submit" class="btn btn-danger mt-2">Submit Comment</button>
                </form>

                <div class="comments-list mt-4">
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment mb-3">
                        <p><strong><?php echo substr(htmlspecialchars($comment['username']), 0, 1); ?>**</strong>:</p>
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
                $fontSize = 10 + ($tag['item_count'] / 10); 
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
</div>

<?php include './includes/footer.php'; ?>