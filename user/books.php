<?php
session_start();
include("../config/db.php");

$search = $_GET['search'] ?? "";
$category = $_GET['category'] ?? "";
if(isset($_GET['view'])){
    $id = (int) $_GET['view'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
    $book = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Details</title>
<link rel="stylesheet" href="../assets/css/books.css?v=5">
</head>
<body>
<div class="book-details">
    <img src="../assets/images/<?php echo $book['image']; ?>">
    <h2><?php echo $book['title']; ?></h2>
    <p><b>Author:</b> <?php echo $book['author']; ?></p>
    <p><b>Price:</b> ₹<?php echo $book['price']; ?></p>
    <p><?php echo $book['description']; ?></p>
    <a class="btn" href="cart.php?add=<?php echo $book['id']; ?>">
        Add to Cart
    </a>
    <br><br>
    <a href="books.php" class="btn">⬅ Back to Books</a>
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
<title>Browse Books</title>
<link rel="stylesheet" href="../assets/css/books.css?v=5">
</head>
<body>
<h1>📚Readora</h1>
<div class="top-bar">
    <div class="categories-nav">
        <a href="books.php" class="<?= ($category=='')?'active':'' ?>">All</a>
        <?php
        $cat = mysqli_query($conn, "SELECT * FROM categories");
        while($c = mysqli_fetch_assoc($cat)){
        ?>
        <a href="?category=<?php echo $c['id']; ?>"
           class="<?= ($category==$c['id'])?'active':'' ?>">
           <?php echo $c['category_name']; ?>
        </a>
        <?php } ?>
    </div>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Search books..."
               value="<?php echo $search; ?>">
        <input type="hidden" name="category" value="<?php echo $category; ?>">
        <button>Search</button>
    </form>
</div>
<br/><br/>
<div class="books">

<?php
$query = "SELECT * FROM products WHERE 1";
if($search != ""){
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND title LIKE '%$search%'";
}
if($category != ""){
    $query .= " AND category_id='$category'";
}
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
?>
<div class="book">
    <img src="../assets/images/<?php echo $row['image']; ?>">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['author']; ?></p>
    <p class="price">₹<?php echo $row['price']; ?></p>
    <a href="?view=<?php echo $row['id']; ?>" class="btn">
        View Details
    </a>
    <a href="cart.php?add=<?php echo $row['id']; ?>" class="btn">
        Add to Cart
    </a>
</div>
<?php } ?>
</div>
<?php include("../includes/footer.php"); ?>
</body>
</html>