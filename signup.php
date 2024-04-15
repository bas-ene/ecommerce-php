<?php
session_start();
if (isset($_SESSION['user'])) {
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Signup</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

	<?php
	include_once './components/Navbar.php';
	$nb = new Navbar();
	$nb->render();

	include_once './components/SignupForm.php';
	$sf = new SignupForm();
	$sf->render();
	?>
</body>

</html>
