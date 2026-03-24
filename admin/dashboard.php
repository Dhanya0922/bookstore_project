<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}
$users = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM users")
);
$books = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM products")
);
$orders = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) as total FROM orders")
);
$revenue = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT SUM(total_amount) as total FROM orders")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/dashboard.css?v=2">
</head>
<body>
<div class="sidebar">
    <h2>Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="categories.php">Add Category</a>
    <a href="manage_orders.php">Manage Orders</a>
    <a href="manage_products.php">Manage Products</a>
    <a href="../logout.php">Logout</a>
</div>
<div class="main">
    <h1>Admin Dashboard</h1>
    <div class="cards">
        <div class="card">
            <h2>Total Users</h2>
            <p><?php echo $users['total']; ?></p>
        </div>
        <div class="card">
            <h2>Total Books</h2>
            <p><?php echo $books['total']; ?></p>
        </div>
        <div class="card">
            <h2>Total Orders</h2>
            <p><?php echo $orders['total']; ?></p>
        </div>
        <div class="card">
            <h2>Total Revenue</h2>
            <p>₹<?php echo $revenue['total']; ?></p>
        </div>
    </div>
</div>
</body>
</html>