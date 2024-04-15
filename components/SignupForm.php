<?php
class SignupForm
{

	private string $formaction = "./checkSignup.php";
	private string $formmethod = "POST";
	private string $formsubmitvalue = "Sign Up";
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
