<?php

namespace AppfulPlugin\Api\Dtos;

class UserRoleDto {
	public string $id = "";
	public string $role_id = "";
	public ?string $expires = null;

	public function __construct( string $id, string $role_id, ?string $expires ) {
		$this->id      = $id;
		$this->role_id = $role_id;
		$this->expires = $expires;
	}
}
