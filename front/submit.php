<?php 
$pageTitle ="Submit";
include './includes/header.php';?>
    
    <main class="container">
        <h1 class="text-center my-5">Submit Your Confession</h1>
        <form action="../config/submit.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="love">Love</option>
                    <option value="family">Family</option>
                    <option value="walai_bilahi">Walai Bilahi</option>
                    <option value="miscellaneous">Miscellaneous</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Confession</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Submit Confession</button>
        </form>
    </main>
    
    <?php include './includes/footer.php';?>
