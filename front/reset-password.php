<?php
$pageTitle = 'Reset Password';
include './includes/header.php';

if(isset($_SESSION['auth'])){
    redirect('index.php', 'You are already Logged In');
}

if(isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify if the token exists and is valid
    $query = "SELECT * FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW() LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // Token is valid
        $userData = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['message'] = "Invalid or expired token.";
        header("Location: forgot-password.php");
        exit(0);
    }
} else {
    header("Location: forgot-password.php");
    exit(0);
}
?>

<div class="py-4 bg-secondary text-center">
    <h4 class="text-white">Reset Password</h4>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Enter New Password</h4>
                    </div>
                    <div class="card-body">
                        <?= alertMessage(); ?> 
                        <form action="reset-password-code.php" method="POST">
                            <input type="hidden" name="token" value="<?= $token; ?>">
                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="mb-4"> 
                                <button type="submit" name="resetPasswordBtn" class="btn btn-primary w-100">Reset Password</button>
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
