<?php
require_once 'database.php';
require_once 'cart.php';
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}
Database::removeFromCart($_SESSION['user'], $_POST['id']);
header('Location: ./viewCart.php');
