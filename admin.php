<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin page</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="styles.css">
</head>

<body>

	<?php
	session_start();
	include_once './components/Navbar.php';
	$navBar = new NavBar();
	$navBar->render();


	include_once 'database.php';
	$products = Database::getProducts();

	include_once 'addProductForm.php';
	$addProduct = new AddProductForm();
	$addProduct->render();
	include_once './components/ProductList.php';
	$productList = new ProductList($products);
	$productList->renderAsTable();
	?>
</body>

</html>
