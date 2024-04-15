<?php
class User
{
	private int $id;
	private string $username;
	private string $password;
	private bool $isAdmin;

	public function __construct(int $id, string $username, string $password, bool $isAdmin)
	{
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->isAdmin = $isAdmin;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function isAdmin(): bool
	{
		return $this->isAdmin;
	}
}
