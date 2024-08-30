<?php 

include('includes/header.php');
?>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Website Settings</h4>
            </div>
            <div class="card-body">
                <?= alertMessage(); ?>

                <form action="admin_functions.php" method="POST">
                    <?php
                        $setting = getById('settings', 1);
                    ?>
                    
                    <input type="hidden" name="settingId" value="<?= $setting['data']['id'] ?? 'insert' ?>">
                    
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" value="<?= $setting['data']['title'] ?? "" ?>" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>URL / Domain</label>
                        <input type="text" name="slug" value="<?= $setting['data']['slug'] ?? "" ?>" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>Small Description</label>
                        <input type="text" name="small_description" value="<?= $setting['data']['small_description'] ?? "" ?>" class="form-control">
                    </div>

                    <h4 class="my-3">SEO Settings</h4>
                    
                    <div class="mb-3">
                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?= $setting['data']['meta_description'] ?? "" ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label>Meta Keyword</label>
                        <textarea name="meta_keyword" class="form-control" rows="3"><?= $setting['data']['meta_keyword'] ?? "" ?></textarea>
                    </div>
                    
                    <div class="row">
                        <h4 class="my-3">Contact Information</h4>
                        
                        <div class="col-md-6 mb-3">
                            <label>Email 1</label>
                            <input type="email" name="email1" value="<?= $setting['data']['email1'] ?? "" ?>" class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Email 2</label>
                            <input type="email" name="email2" value="<?= $setting['data']['email2'] ?? "" ?>" class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Phone 1</label>
                            <input type="text" name="phone1" value="<?= $setting['data']['phone1'] ?? "" ?>" class="form-control">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Phone 2</label>
                            <input type="text" name="phone2" value="<?= $setting['data']['phone2'] ?? "" ?>" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3"><?= $setting['data']['address'] ?? "" ?></textarea>
                        </div>
                    </div>
                    
                    <div class="mb-3 text-end">
                        <button type="submit" name="saveSetting" class="btn btn-primary">Save Setting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>
