<?php
require_once 'database.php';
require_once 'cart.php';
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}

$id = $_POST['id'];
$quantity = $_POST['quantity'];

if ($quantity == 0) {
	$cart = $_SESSION['cart'];
	$cart->removeProduct($id);
	$_SESSION['cart'] = $cart;
	Database::removeFromCart($_SESSION['user'], $id);
} else {
	$cart = $_SESSION['cart'];
	$cart->updateProduct($id, $quantity);
	$_SESSION['cart'] = $cart;
	Database::updateCart(, $id, $quantity);
}
