<?php
session_start();
include("config/db.php");

$msg = "";
$type = "";
if(isset($_POST['login'])){
    $loginType = $_POST['login']; 
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password,$user['password'])){
            if($user['role'] != $loginType){
                $msg = "Access denied for this role!";
                $type = "error";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                if($user['role'] == 'admin'){
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            }
        } else {
            $msg = "Incorrect password!";
            $type = "error";
        }
    } else {
        $msg = "User not found!";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body
<?php include("includes/header.php"); ?>
<div class="auth-container"> 
    <div class="auth-form">
        <?php if(isset($msg)){ ?>
            <div class="msg-box <?php echo $type; ?>">
                <?php echo ($type=="error") ? "⚠ " : "✔ "; ?>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
        <div class="auth-box">
            <h2>Login</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" name="login" value="customer">User Login</button>
                <button type="submit" name="login" value="admin">Admin Login</button>
                <p class="link">
                    Don't have an account? <a href="register.php">Register</a>
                </p>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <div class="info-box">
            <h2>Welcome Back👋</h2>
            <p>Login to continue exploring your favorite books and manage your orders easily.</p>
            <ul>
                <li>✔ Access Your Orders</li>
                <li>✔ Save Favorite Books</li>
                <li>✔ Fast Checkout</li>
                <li>✔ Secure Login</li>
            </ul>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
</body>
</html>