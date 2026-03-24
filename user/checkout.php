<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
$user = $_SESSION['user_id'];
if(isset($_POST['place_order'])){
    $total = 0;
    $cart = mysqli_query($conn,
    "SELECT cart.*, products.price 
     FROM cart 
     JOIN products ON cart.product_id = products.id
     WHERE cart.user_id='$user'");
    while($c = mysqli_fetch_assoc($cart)){
        $total += $c['price'] * $c['quantity'];
    }
    mysqli_query($conn,
    "INSERT INTO orders(user_id,total_amount)
     VALUES('$user','$total')");
    $order_id = mysqli_insert_id($conn);
    $cart = mysqli_query($conn,
    "SELECT cart.*, products.price 
     FROM cart 
     JOIN products ON cart.product_id = products.id
     WHERE cart.user_id='$user'");
    while($c = mysqli_fetch_assoc($cart)){
        mysqli_query($conn,
        "INSERT INTO order_items(order_id,product_id,quantity,price)
         VALUES('$order_id','".$c['product_id']."','".$c['quantity']."','".$c['price']."')");
    }
    mysqli_query($conn,"DELETE FROM cart WHERE user_id='$user'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>
<link rel="stylesheet" href="../assets/css/cart.css?v=5">
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="cart-container" style="text-align:center; margin-top:150px;">
    <h1 style="color:lightgreen;">Order Placed Successfully 🎉</h1>
    <a href="books.php" class="checkout">
        Continue Shopping
    </a>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>
<?php
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="../assets/css/cart.css?v=5">
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="cart-container">
    <h1>Checkout 🧾</h1>
    <table>
        <tr>
            <th>Book</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php
        $total = 0;
        $cart = mysqli_query($conn,
        "SELECT cart.*, products.title, products.price 
         FROM cart 
         JOIN products ON cart.product_id = products.id
         WHERE cart.user_id='$user'");
        while($row = mysqli_fetch_assoc($cart)){
            $sub = $row['price'] * $row['quantity'];
            $total += $sub;
        ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>₹<?php echo $sub; ?></td>
        </tr>
        <?php } ?>
    </table>
    <div class="cart-summary">
        <h2>Total: ₹<?php echo $total; ?></h2>
        <form method="POST">
            <button class="checkout" name="place_order">
                Place Order
            </button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>