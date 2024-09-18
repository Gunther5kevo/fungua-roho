<?php
include '../config/server.php';
include '../config/fetch.php';


$tag_name = $_GET['tag'];

$pageTitle= "Fungua Roho -$tag_name";
include './includes/header.php';

// Fetch tag details and related confessions
$tag_sql = "SELECT id FROM tags WHERE name = ?";
$stmt = $conn->prepare($tag_sql);
$stmt->bind_param('s', $tag_name);
$stmt->execute();
$result = $stmt->get_result();
$tag = $result->fetch_assoc();

if (!$tag) {
    die('Tag not found');
}

$tag_id = $tag['id'];

// Fetch confessions with the selected tag
$confessions_sql = "SELECT confessions.id, confessions.title, confessions.content, categories.name AS category, GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags 
                    FROM confessions 
                    JOIN categories ON confessions.category_id = categories.id 
                    LEFT JOIN confession_tags ON confessions.id = confession_tags.confession_id 
                    LEFT JOIN tags ON confession_tags.tag_id = tags.id 
                    WHERE tags.id = ? 
                    GROUP BY confessions.id 
                    ORDER BY confessions.created_at DESC";
$stmt = $conn->prepare($confessions_sql);
$stmt->bind_param('i', $tag_id);
$stmt->execute();
$confessions_result = $stmt->get_result();
$confessions = $confessions_result->fetch_all(MYSQLI_ASSOC);


?>




<style>
    .sidebar {
            background-color: #f8f9fa;
            padding: 15px;
        }
</style>

<body>
    

    <main class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8">
                <h1 class="text-center my-5"># <?php echo htmlspecialchars($tag_name); ?></h1>

                <?php if (empty($confessions)): ?>
                    <p class="text-center">No confessions found for this tag.</p>
                <?php else: ?>
                    <?php foreach ($confessions as $confession): ?>
                        <div class="confession mb-4">
                            <h3><?php echo htmlspecialchars($confession['title']); ?></h3>
                            <p><?php echo substr(htmlspecialchars($confession['content']), 0, 100) . '...'; ?></p>
                            <p><strong>Tags:</strong> <?php echo htmlspecialchars($confession['tags']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($confession['category']); ?></p>
                            <a href="confession.php?id=<?php echo $confession['id']; ?>" class="btn btn-link">Read More</a>
                            <div class="like-dislike-container mt-2">
                                <button class="btn btn-link">👍</button>
                                <button class="btn btn-link">👎</button>
                            </div>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </main>
    
    <?php include './includes/footer.php';?>
