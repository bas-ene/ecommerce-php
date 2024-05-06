<?php
include_once 'user.php';
include_once 'database.php';
if (!isset($_GET['id'])) {
	header('Location: ./index.php');
	exit;
}
session_start();
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

	Database::getProduct($_GET['id'])->renderDetails();
	?>
</body>

</html>
<?php
?>
