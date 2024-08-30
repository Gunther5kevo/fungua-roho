<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Add Social Media
                    <a href="social-media.php" class="btn btn-danger float-end">Back</a>
                </h4>
            </div>
            <div class="card-body">
                <?= alertMessage(); ?>
                <form action="admin_functions.php" method="POST">
                    <div class="mb-3">
                        <label>Social Media Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Social Media URL/Link</label>
                        <input type="text" name="url" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <br />
                        <input type="checkbox" name="status" value="active" style="width: 38px; height: 30px;">
                        <!-- Hidden field to handle unchecked state -->
                        <input type="hidden" name="status" value="inactive">
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" name="saveSocialMedia" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
