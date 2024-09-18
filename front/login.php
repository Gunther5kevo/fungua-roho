<?php
$pageTitle = 'Login';
include './includes/header.php';
include 'google-signin.php';

if(isset($_SESSION['auth'])){
    redirect('index.php', 'You are already Logged In');
}

if (!isset($client)) {
    die('Google Client is not initialized properly.');
}
?>

<div class="py-4 bg-secondary text-center">
    <h4 class="text-white">Login</h4>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?= alertMessage(); ?> 
                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                            </div>
                            <div class="mb-4"> 
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
                        <hr>
                        <div class="mb-3 text-center">
                            <a href="<?php echo htmlspecialchars($client->createAuthUrl(), ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger w-100">
                                <i class="fab fa-google"></i> Sign in with Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>
