<?php
include("../config/db.php");

if(isset($_GET['id'])){
$id = $_GET['id'];
}else{
echo "No product selected";
exit();
}
$product = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM products WHERE id='$id'")
);

if(isset($_POST['update'])){
$title=$_POST['title'];
$author=$_POST['author'];
$price=$_POST['price'];
$description=$_POST['description'];
$category_id=$_POST['category_id'];
$stock=$_POST['stock'];
mysqli_query($conn,"
UPDATE products SET
title='$title',
author='$author',
price='$price',
description='$description',
category_id='$category_id',
stock='$stock'
WHERE id='$id'
");
header("Location: manage_products.php?msg=updated");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Book</title>
<link rel="stylesheet" href="../assets/css/edit_product.css">
</head>
<body>
<div class="container">
<h2>Edit Book</h2>
<form method="POST">
Title
<input type="text" name="title"
value="<?php echo $product['title']; ?>">
Author
<input type="text" name="author"
value="<?php echo $product['author']; ?>">
Price
<input type="number" name="price"
value="<?php echo $product['price']; ?>">
Description
<textarea name="description"><?php echo $product['description']; ?></textarea>
Category
<select name="category_id">
<?php
$cat=mysqli_query($conn,"SELECT * FROM categories");
while($c=mysqli_fetch_assoc($cat)){
?>
<option value="<?php echo $c['id']; ?>">
<?php echo $c['category_name']; ?>
</option>
<?php } ?>
</select>
Stock
<input type="number" name="stock"
value="<?php echo $product['stock']; ?>">
<button name="update">Update Book</button>
</form>
</div>
</body>
</html>