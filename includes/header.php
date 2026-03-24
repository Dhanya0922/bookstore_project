<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar">
<h2>📚Readora</h2>
<ul>
<li>
<a href="/bookstore_project/index.php"
class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">
Home
</a>
</li>

<li>
<a href="/bookstore_project/user/books.php"
class="<?= ($current_page == 'books.php') ? 'active' : '' ?>">
Books
</a>
</li>

<li>
<a href="/bookstore_project/register.php"
class="<?= ($current_page == 'register.php') ? 'active' : '' ?>">
Register
</a>
</li>

<li>
<a href="/bookstore_project/login.php"
class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">
Login
</a>
</li>

<li>
<a href="/bookstore_project/user/cart.php"
class="<?= ($current_page == 'cart.php') ? 'active' : '' ?>">
Cart
</a>
</li>

<li>
<a href="/bookstore_project/user/checkout.php"
class="<?= ($current_page == 'checkout.php') ? 'active' : '' ?>">
CheckOut
</a>
</li>

<li>
<a href="/bookstore_project/user/orders.php"
class="<?= ($current_page == 'orders.php') ? 'active' : '' ?>">
Orders
</a>
</li>

<li>
<a href="/bookstore_project/logout.php">
Logout
</a>
</li>
</ul>
</nav>