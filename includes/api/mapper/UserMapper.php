<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\UserDto;
use AppfulPlugin\Domain\User;
use AppfulPlugin\Domain\UserRole;

class UserMapper {
	public static function to_dto( User $author ): UserDto {
		return new UserDto(
			$author->get_id(),
			$author->get_firstname(),
			$author->get_lastname(),
			$author->get_avatar(),
			$author->get_display_name(),
			array_map(
				function ( UserRole $role ) {
					return UserRoleMapper::to_dto( $role );
				},
				$author->get_roles()
			),
		);
	}
}
