<?php
$pageTitle = 'Forgot Password';
include './includes/header.php';

if(isset($_SESSION['auth'])){
    redirect('index.php', 'You are already Logged In');
}
?>

<div class="py-4 bg-secondary text-center">
    <h4 class="text-white">Forgot Password</h4>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <?= alertMessage(); ?> 
                        <form action="forgot-password-code.php" method="POST">
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-4"> 
                                <button type="submit" name="resetPasswordBtn" class="btn btn-primary w-100">Send Reset Link</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <a href="login.php" class="text-decoration-none">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>
