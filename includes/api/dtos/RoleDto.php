<?php

namespace AppfulPlugin\Api\Dtos;

class RoleDto {
	public string $id = "";
	public string $name = "";

	public function __construct( string $id, string $name ) {
		$this->id   = $id;
		$this->name = $name;
	}
}
