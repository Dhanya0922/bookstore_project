<?php
include("config/db.php");

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
$role = 'customer';
$sql = "INSERT INTO users (name,email,password,role)
VALUES ('$name','$email','$hashed_password','$role')";
    if(mysqli_query($conn,$sql)){
        $msg = "Registration Successful!";
        $type = "success";
    } else {
        $msg = "Error occurred!";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="auth-container">
    <div class="auth-form">
        <?php if(isset($msg)){ ?>
            <div class="msg-box <?php echo $type; ?>">
                <?php echo ($type=="success") ? "✔ " : "⚠ "; ?>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
        <div class="auth-box">
            <h2>Register</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="phone" placeholder="Phone">
                <textarea name="address" placeholder="Address"></textarea>

                <button name="register">Register</button>
                <p class="link">Already have account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <div class="auth-image">
        <div class="info-box">
            <h2>Welcome to 📚Readora</h2>
            <p>Create your account to explore thousands of books, manage orders, and enjoy a seamless reading experience.</p>
            <ul>
                <li>✔ Easy Book Search</li>
                <li>✔ Fast Checkout</li>
                <li>✔ Order Tracking</li>
                <li>✔ Secure Payments</li>
            </ul>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
</body>
</html>