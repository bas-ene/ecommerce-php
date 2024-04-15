<?php
include_once 'database.php';
include_once 'user.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = Database::loginUser($username, $password);
	if ($user !== null) {
		session_start();
		$_SESSION['user'] = $user;
		header('Location: index.php');
	} else {
		header('Location: login.php');
	}
} else {
	echo "Invalid request";
}
