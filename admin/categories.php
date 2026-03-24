<?php
include("../config/db.php");

if(isset($_POST['add'])){
$name=$_POST['category_name'];
mysqli_query($conn,"INSERT INTO categories(category_name)
VALUES('$name')");
}
if(isset($_GET['delete'])){
$id=$_GET['delete'];
mysqli_query($conn,"DELETE FROM categories WHERE id='$id'");
}
if(isset($_POST['update'])){
$id=$_POST['id'];
$name=$_POST['category_name'];
mysqli_query($conn,"UPDATE categories
SET category_name='$name'
WHERE id='$id'");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Category Management</title>
<link rel="stylesheet" href="../assets/css/category.css?v=2">
</head>
<body>
<h2>Add Category</h2>
<form method="POST">
<input type="text" name="category_name" placeholder="Category Name" required>
<button name="add">Add Category</button>
</form>

<br/><br/>
<h2>Category List</h2>
<table>
<tr>
<th>ID</th>
<th>Category Name</th>
<th>Action</th>
</tr>
<?php
$result=mysqli_query($conn,"SELECT * FROM categories");
while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['category_name']; ?></td>
<td>
<a href="?edit=<?php echo $row['id']; ?>">Edit</a>
<a href="?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Are you sure you want to delete this category?')">
   Delete
</a>
</td>
</tr>
<?php } ?>
</table>

<?php
if(isset($_GET['edit'])){
$id=$_GET['edit'];
$cat=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM categories WHERE id='$id'"));
?>
<br/><br/>

<h2>Edit Category</h2>
<form method="POST">
<input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
<input type="text" name="category_name"
value="<?php echo $cat['category_name']; ?>">
<button name="update">Update Category</button>
</form>

<?php } ?>
<div id="confirmBox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
    <div style="background:white; padding:20px; border-radius:10px; text-align:center;">
        <p>Do you want to delete this category?</p>
        <button onclick="confirmDelete()">Yes</button>
        <button onclick="closeBox()">No</button>
    </div>
</div>
</body>
</html>