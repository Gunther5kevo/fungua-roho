<div class="recent-comments-section mb-4">
    <h5>Recent Comments</h5>
    <ul id="recent-comments-list" class="list-group">
        <?php if (!empty($recent_comments)): ?>
            <?php foreach ($recent_comments as $comment): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars(substr($comment['username'], 0, 1)); ?>**:</strong>
                    <p>
                        <a href="../front/confession.php?id=<?php echo htmlspecialchars($comment['confession_id']); ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars(substr($comment['content'], 0, 50)) . '...'; ?>
                        </a>
                    </p>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item">No comments found.</li>
        <?php endif; ?>
    </ul>

    <button id="load-more-comments" class="btn btn-primary mt-3">Load More</button>
</div>

<!-- Load full version of jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    let offset = 5;  // Start loading from the 6th comment
    const limit = 5; // Load 5 comments at a time

    $('#load-more-comments').click(function(){
        $.ajax({
            url: 'load_comments.php',  // Path to your PHP file
            type: 'POST',
            data: { limit: limit, offset: offset },
            success: function(response) {
                // Append the new comments to the list
                response.forEach(comment => {
                    $('#recent-comments-list').append(`
                        <li class="list-group-item">
                            <strong>${comment.username.charAt(0)}**:</strong>
                            <p>
                                <a href="confession.php?id=${comment.confession_id}" class="text-decoration-none">
                                    ${comment.content.substring(0, 50)}...
                                </a>
                            </p>
                        </li>
                    `);
                });

                // Increase the offset for the next set of comments
                offset += limit;

                // Hide the button if fewer comments are returned (no more to load)
                if (response.length < limit) {
                    $('#load-more-comments').hide();
                }
            },
            error: function() {
                alert('Error loading more comments');
            }
        });
    });
});
</script>
