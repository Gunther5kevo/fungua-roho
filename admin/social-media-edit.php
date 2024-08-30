<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Edit Social Media
                    <a href="social-media.php" class="btn btn-danger float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <?= alertMessage(); ?>
                <form action="admin_functions.php" method="POST">

                    <?php
                    $paramResult = checkParamId('id'); // Get the 'id' from URL parameters
                    
                    // Check if the ID is numeric
                    if (!is_numeric($paramResult)) {
                        echo "<h5>" . htmlspecialchars($paramResult) . "</h5>";
                        return false; // Stop execution if ID is invalid
                    }

                    $socialMedia = getById('social_media', $paramResult);

                    if ($socialMedia && $socialMedia['status'] == 200) {
                        $data = $socialMedia['data']; // Get the actual data
                        ?>

                        <input type="hidden" name="socialMediaId" value="<?= htmlspecialchars($data['id']); ?>">
                        <div class="mb-3">
                            <label>Social Media Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Social Media URL/Link</label>
                            <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($data['url']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <br />
                            <input type="checkbox" name="status" value="active" style="width: 38px; height: 30px;" <?= $data['status'] == 'active' ? 'checked' : ''; ?>>
                            <!-- Hidden field to handle unchecked state -->
                            <input type="hidden" name="status" value="inactive">
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" name="updateSocialMedia" class="btn btn-primary">Save</button>
                        </div>
                        <?php
                    } else {
                        echo "<h5>Something Went Wrong</h5>";
                    }
                    ?>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
