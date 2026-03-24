<?php
include("config/db.php");

$newPassword = password_hash("admin123", PASSWORD_DEFAULT);
mysqli_query($conn, "UPDATE users SET password='$newPassword' WHERE email='admin@gmail.com'");
echo "Password reset successfully!";
?>