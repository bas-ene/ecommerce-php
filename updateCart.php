<?php
require_once 'database.php';
require_once 'cart.php';

use app\User;

session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}

$id = $_POST['id'];
$quantity = $_POST['quantity'];
$user = $_SESSION['user'];

if ($quantity == 0) {
	$cart = $_SESSION['cart'];
	$cart->removeProduct($id);
	$_SESSION['cart'] = $cart;
	Database::removeFromCart($_SESSION['user'], $id);
} else {
	if (!is_numeric($quantity) || $quantity < 0) {
		header('Location: ./viewCart.php');
		exit;
	}
	$product = Database::getProduct($id);

	if ($quantity > $product->getQuantity()) {
		header('Location: ./viewCart.php');
		exit;
	}
	$cart = $_SESSION['cart'];
	$cart->updateProduct($id, $quantity);
	$_SESSION['cart'] = $cart;

	Database::updateCart($user, $id, $quantity);
}

header('Location: ./viewCart.php');
