<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}
$user = $_SESSION['user_id'];

if(isset($_GET['add'])){
    $product_id = (int) $_GET['add'];
    $check = mysqli_query($conn,
    "SELECT * FROM cart WHERE user_id='$user' AND product_id='$product_id'");
    if(mysqli_num_rows($check) > 0){
        mysqli_query($conn,
        "UPDATE cart SET quantity = quantity + 1 
         WHERE user_id='$user' AND product_id='$product_id'");
    } else {
        mysqli_query($conn,
        "INSERT INTO cart(user_id,product_id,quantity)
         VALUES('$user','$product_id',1)");
    }
    header("Location: cart.php");
    exit();
}

if(isset($_GET['remove'])){
    $id = (int) $_GET['remove'];
    mysqli_query($conn,"DELETE FROM cart WHERE id='$id'");
    header("Location: cart.php");
    exit();
}

if(isset($_POST['update'])){
    $id = (int) $_POST['id'];
    $qty = (int) $_POST['quantity'];
    if($qty > 0){
        mysqli_query($conn,
        "UPDATE cart SET quantity='$qty' WHERE id='$id'");
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart</title>
<link rel="stylesheet" href="../assets/css/cart.css?v=5">
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="cart-container">
    <h1>Your Shopping Cart 🛒</h1>
    <table>
        <tr>
            <th>Book</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        $total = 0;
        $cart = mysqli_query($conn,
        "SELECT cart.*, products.title, products.price 
         FROM cart 
         JOIN products ON cart.product_id = products.id 
         WHERE cart.user_id='$user'");
        if(mysqli_num_rows($cart) > 0){
        while($row = mysqli_fetch_assoc($cart)){
            $sub = $row['price'] * $row['quantity'];
            $total += $sub;
        ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td>
                <form method="POST" class="qty-form">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity"
                    value="<?php echo $row['quantity']; ?>" min="1">
                    <button name="update">Update</button>
                </form>
            </td>
            <td>₹<?php echo $sub; ?></td>
            <td>
                <a href="?remove=<?php echo $row['id']; ?>" class="remove">
                    Remove
                </a>
            </td>
        </tr>
        <?php } } else { ?>
        <tr>
            <td colspan="5">Your cart is empty 🛍️</td>
        </tr>
        <?php } ?>
    </table>
    <div class="cart-summary">
        <h2>Total: ₹<?php echo $total; ?></h2>
        <?php if($total > 0){ ?>
        <a class="checkout" href="checkout.php">
            Proceed to Checkout
        </a>
        <?php } ?>
    </div>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>