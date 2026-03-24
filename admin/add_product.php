<?php
session_start();
include("../config/db.php");

if(isset($_POST['add_product'])){
$title = $_POST['title'];
$author = $_POST['author'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$stock = $_POST['stock'];
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
move_uploaded_file($tmp,"../assets/images/".$image);
$sql = "INSERT INTO products(title,author,price,description,image,category_id,stock)
VALUES('$title','$author','$price','$description','$image','$category_id','$stock')";

if(mysqli_query($conn,$sql)){
echo "<p class='success' style='color: white; margin-top:20px; font-size:30px;'>Book Added Successfully🎉</p>";
}else{
echo "Error: ".mysqli_error($conn);
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Book</title>

<style>
body{
    font-family: Arial;
    margin:0;
    padding:0;
    background:url("https://wallpapercave.com/wp/wp6974517.jpg");
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;
}
body::before{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:-1;
}
.container{
width:450px;
margin:50px auto;
background:white;
padding:25px;
border-radius:6px;
box-shadow:0 0 10px rgba(0,0,0,0.4);
}
h2{
text-align:center;
color:brown;
}
input, textarea, select{
width:100%;
padding:10px;
margin-top:8px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:4px;
}
button{
background: rgb(228, 163, 174);
color:black;
border:none;
padding:10px;
width:100%;
font-size:16px;
cursor:pointer;
border-radius:4px;
}
button:hover{
background:green;
color:white;
}
.success{
color:green;
text-align:center;
}
</style>

</head>
<body>
<div class="container">
<h2 style='color: black;'>Add New Book</h2>
<form method="POST" enctype="multipart/form-data">
Title
<input type="text" name="title" required>
Author
<input type="text" name="author" required>
Price
<input type="number" name="price" required>
Description
<textarea name="description"></textarea>
Category
<select name="category_id">
<?php
$cat = mysqli_query($conn,"SELECT * FROM categories");
while($c = mysqli_fetch_assoc($cat)){
echo "<option value='".$c['id']."'>".$c['category_name']."</option>";
}
?>
</select>
Stock
<input type="number" name="stock" required>
Book Image
<input type="file" name="image" required>
<button name="add_product">Add Book</button>
</form>
</div>
</body>
</html>