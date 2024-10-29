<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\RoleDto;
use AppfulPlugin\Domain\Role;

class RoleMapper {
	public static function to_dto( Role $role ): RoleDto {
		return new RoleDto(
			$role->get_id(),
			$role->get_name(),
		);
	}
}
