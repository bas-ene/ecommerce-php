<?php
require_once 'database.php';
include_once 'user.php';

session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}

if (!isset($_POST['id'])) {
	header('Location: ./index.php');
	exit;
}


$pId = $_POST['id'];
$product = Database::getProduct($pId);
$user = $_SESSION['user'];
$cart = Database::getCart($user);
if ($cart === null) {
	Database::createCart($user);
	$cart = Database::getCart($user);
}

$cart->addProduct($product);
Database::addToCart($_SESSION['user'], $pId, 1);
$_SESSION['cart'] = $cart;

header('Location: ./viewCart.php');
