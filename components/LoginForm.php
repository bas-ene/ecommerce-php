<?php
class LoginForm
{
	private string $formaction = "./checkLogin.php";
	private string $formmethod = "POST";
	private string $formsubmitvalue = "Log in";
	public function render()
	{
		echo "<form action='$this->formaction' method='$this->formmethod'>";
		echo "<input type='text' name='username' placeholder='Username' required/>";
		echo "<br>";
		echo "<input type='password' name='password' placeholder='Password' required/>";
		echo "<br>";
		echo "<input type='submit' value='$this->formsubmitvalue' />";
		echo "</form>";
	}
}
