<?php
include_once 'user.php';
include_once 'database.php';
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: ./login.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cart</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<?php
	session_start();
	include_once './components/Navbar.php';
	$navBar = new NavBar();
	$navBar->render();

	$cart = Database::getCart($_SESSION['user']);
	$cart->render();
	?>
</body>

</html>
<?php
?>
