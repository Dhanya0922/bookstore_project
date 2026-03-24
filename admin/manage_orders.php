<?php
session_start();
include("../config/db.php");

if(isset($_POST['update_status'])){
$id = $_POST['order_id'];
$status = $_POST['status'];
mysqli_query($conn,
"UPDATE orders SET order_status='$status' WHERE id='$id'");
}
$orders = mysqli_query($conn,
"SELECT orders.*, users.name 
FROM orders 
JOIN users ON orders.user_id = users.id
ORDER BY orders.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Orders</title>
<link rel="stylesheet" href="../assets/css/manage_orders.css?v=2">
</head>
<body>
<h1>Manage Orders</h1>
<table>
<tr>
<th>Order ID</th>
<th>User</th>
<th>Total Amount</th>
<th>Status</th>
<th>Date</th>
<th>Update Status</th>
</tr>
<?php while($row=mysqli_fetch_assoc($orders)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td>₹<?php echo $row['total_amount']; ?></td>
<td><?php echo $row['order_status']; ?></td>
<td><?php echo $row['created_at']; ?></td>
<td>
<form method="POST">
<input type="hidden" name="order_id"
value="<?php echo $row['id']; ?>">
<select name="status">
<option>Pending</option>
<option>Processing</option>
<option>Shipped</option>
<option>Delivered</option>
<option>Cancelled</option>
</select>
<button name="update_status">Update</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>