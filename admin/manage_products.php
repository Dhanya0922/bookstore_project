<?php
include("../config/db.php");

if(isset($_GET['delete'])){
$id = $_GET['delete'];
mysqli_query($conn,"DELETE FROM products WHERE id='$id'");
header("Location: manage_products.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Books</title>
<link rel="stylesheet" href="../assets/css/manage_products.css">
</head>
<body>
<h1>Manage Books📖</h1>
<?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'){ ?>
<div class="success-msg">Book updated successfully ✔</div>
<?php } ?>
<a class="add-btn" href="add_product.php">Add New Book +</a>
<table>
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Author</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>
</tr>
<?php
$sql="SELECT * FROM products";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td>
<img src="../assets/images/<?php echo $row['image']; ?>" width="60">
</td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['author']; ?></td>
<td>₹<?php echo $row['price']; ?></td>
<td><?php echo $row['stock']; ?></td>
<td>
<a class="edit" href="edit_product.php?id=<?php echo $row['id']; ?>">
Edit
</a>
<a class="delete" 
   href="?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Do you want to delete this book?')">
   Delete
</a>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>