<?php
include '../config/server.php';

$category_name = $_GET['category'];

$stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
$stmt->bind_param("s", $category_name);
$stmt->execute();
$category_id_result = $stmt->get_result();
$category_id_row = $category_id_result->fetch_assoc();
$category_id = $category_id_row['id'];
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM confessions WHERE category_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fungua Roho - Category</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('header.php');?>
    
    <main class="container">
        <h1 class="text-center my-5"> <?php echo htmlspecialchars(ucfirst($category_name)); ?></h1>
        <div class="row">
            <div class="col-md-12">
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="confession">
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($row['content'], 0, 100)) . '...'; ?></p>
                            <a href="confession.php?id=<?php echo $row['id']; ?>" class="btn btn-link">Read More</a>
                        </div>
                        <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No confessions found in this category.</p>
                <?php endif; ?>
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

<?php $conn->close(); ?>
