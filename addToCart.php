<?php
require_once 'database.php';
include_once 'user.php';

session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}

if (!isset($_POST['id']) || !isset($_POST['quantity']) || $_POST['quantity'] <= 0) {
	header('Location: ./index.php');
	exit;
}


$pId = $_POST['id'];
$quantity = $_POST['quantity'];
$product = Database::getProduct($pId);
$user = $_SESSION['user'];
$cart = Database::getCart($user);
if ($cart === null) {
	Database::createCart($user);
}

Database::addToCart($_SESSION['user'], $pId, $quantity);
$cart = Database::getCart($user);
$_SESSION['cart'] = $cart;

header('Location: ./viewCart.php');
