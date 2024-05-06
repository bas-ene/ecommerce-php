
<?php
include_once 'database.php';

use app\User;

if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = Database::signupUser(new User(-1, $username, $password, false));
	if ($user !== null) {
		session_start();
		$_SESSION['user'] = $user;
		$_SESSION['admin'] = false;
		header('Location: index.php');
	} else {
		echo "Invalid credentials";
	}
} else {
	echo "Invalid request";
}
