<?php
include_once 'database.php';
include_once 'user.php';

use app\User;

if (isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user = Database::loginUser($username, $password);
	if ($user !== null) {
		session_start();
		$_SESSION['user'] = $user;
		if ($user->isAdmin()) {
			$_SESSION['admin'] = true;
		}
		header('Location: index.php');
	} else {
		header('Location: login.php');
	}
} else {
	echo "Invalid request";
}
