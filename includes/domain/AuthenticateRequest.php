<?php

namespace AppfulPlugin\Domain;

class AuthenticateRequest {
	private string $username;
	private string $password;

	public function __construct(
		string $username,
		string $password
	) {
		$this->username = $username;
		$this->password = $password;
	}

	public function get_username(): string {
		return $this->username;
	}

	public function get_password(): string {
		return $this->password;
	}
}
