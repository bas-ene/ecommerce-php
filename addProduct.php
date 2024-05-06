<?php
// if (!isset($_SESSION['admin'])) {
// 	header('Location: login.php');
// 	exit;
// }

if (isset($_POST['name'])) {
	include_once 'database.php';
	$name = $_POST['name'];
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];
	$description = $_POST['description'];
	$image = basename($_FILES['image']['name']);
	$tmp_name = $_FILES['image']['tmp_name'];
	move_uploaded_file($tmp_name, 'img/' . $image);
	Database::addProduct($name, $price, $quantity, $description, $image);
	header('Location: index.php');
}
