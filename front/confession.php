<?php
include '../config/server.php';

$id = $_GET['id'];
$sql = "SELECT * FROM confessions WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fungua Roho - Confession</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .confession-content {
            border: 1px solid #e6005c; /* Valentine red */
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-interaction {
            border-radius: 20px;
            padding: 10px 20px;
        }
        .interaction-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
        }
        .like-dislike-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
        .comment-section {
            margin-top: 30px;
        }
        .comment-input {
            border-radius: 20px;
            padding: 10px;
            width: 100%;
            border: 1px solid #ddd;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<?php include('header.php');?>
    
    <main class="container">
        <h1 class="text-center my-5"><?php echo htmlspecialchars($row['title']); ?></h1>
        <div class="confession-content">
            <p><?php echo htmlspecialchars($row['content']); ?></p>
        </div>
        <div class="interaction-container text-center mt-4">
            <button class="btn btn-danger btn-interaction">Like</button>
            <button class="btn btn-outline-danger btn-interaction">Dislike</button>
        </div>
        <div class="comment-section">
            <h5>Comments:</h5>
            <!-- Example of a comment input and existing comments -->
            <textarea class="comment-input" rows="3" placeholder="Add a comment..."></textarea>
            <button class="btn btn-danger mt-2">Submit Comment</button>
            <div class="mt-4">
                <!-- Display existing comments here -->
                <!-- Example comment -->
                <div class="comment">
                    <strong>John Doe:</strong>
                    <p>This is a sample comment.</p>
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

<?php $conn->close(); ?>
