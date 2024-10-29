<?php

namespace AppfulPlugin\Api\Dtos;

class LogoutDto {
	public string $token = "";

	public function __construct( string $token ) {
		$this->token = $token;
	}
}