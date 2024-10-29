<?php

namespace AppfulPlugin\Api\Dtos;

class UserDto {
	public int $id = - 1;
	public string $firstname = "";
	public string $lastname = "";
	public string $avatar = "";
	public string $display_name = "";
	/** @var UserRoleDto[] */
	public array $roles = [];

	/**
	 * @param UserRoleDto[] $roles
	 */
	public function __construct( int $id, string $firstname, string $lastname, string $avatar, string $display_name, array $roles ) {
		$this->id           = $id;
		$this->firstname    = $firstname;
		$this->lastname     = $lastname;
		$this->avatar       = $avatar;
		$this->display_name = $display_name;
		$this->roles        = $roles;
	}
}
