<h1>View cart</h1>
<?php
include_once 'user.php';
include_once 'database.php';
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}
$cart = Database::getCart($_SESSION['user']);
print_r($cart);
?>
<h2>Products</h2>
