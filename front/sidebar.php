<!-- sidebar.php -->
<div class="sidebar mb-4">
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
