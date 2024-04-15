<?php
class Navbar
{
	public function render()
	{
		session_start();

		echo '<nav class="bg-blue-500 p-4 text-white">';
		echo '<a href="/index.php" class="mr-4">Home</a>';

		if (isset($_SESSION['user'])) {
			echo '<a href="/logout.php" class="mr-4">Logout</a>';
		} else {
			echo '<a href="/login.php" class="mr-4">Login</a>';
			echo '<a href="/signup.php" class="mr-4">Register</a>';
		}
		echo '<a href="/viewCart.php" class="mr-4">Cart</a>';
		echo '</nav>';
	}
}
