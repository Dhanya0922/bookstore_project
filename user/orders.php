<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
$user = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link rel="stylesheet" href="../assets/css/orders.css?v=4">
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="cart-container">
    <h1 style='color:white'>My Orders📦</h1>
    <?php
    $orders = mysqli_query($conn,
    "SELECT * FROM orders WHERE user_id='$user' ORDER BY id DESC");
    if(mysqli_num_rows($orders) > 0){
    while($order = mysqli_fetch_assoc($orders)){
    ?>
    <div class="order-box">
        <div class="order-header">
            <h2 style='color:black;'>Order <?php echo $order['id']; ?></h2>
            <span class="status"><?php echo $order['order_status']; ?></span>
        </div>
        <p class="date">📅 <?php echo $order['created_at']; ?></p>
        <table>
            <tr>
                <th>Book</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php
            $items = mysqli_query($conn,
            "SELECT order_items.*, products.title 
             FROM order_items 
             JOIN products ON order_items.product_id = products.id
             WHERE order_items.order_id=".$order['id']);
            while($item = mysqli_fetch_assoc($items)){
                $sub = $item['price'] * $item['quantity'];
            ?>
            <tr>
                <td><?php echo $item['title']; ?></td>
                <td>₹<?php echo $item['price']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₹<?php echo $sub; ?></td>
            </tr>
            <?php } ?>
        </table>
        <div class="order-footer">
            <h3>Total: ₹<?php echo $order['total_amount']; ?></h3>
        </div>
    </div>
<br/><br/><br/>
    <?php } } else { ?>
    <p style="text-align:center; color:white;">No orders yet 🛍️</p>
    <?php } ?>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>