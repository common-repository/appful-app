<?php

namespace AppfulPlugin\api\mapper;

use AppfulPlugin\Api\Dtos\UserRoleDto;
use AppfulPlugin\Domain\UserRole;
use AppfulPlugin\Helper\DateParser;

class UserRoleMapper {
	public static function to_dto( UserRole $role ): UserRoleDto {
		return new UserRoleDto(
			$role->get_id(),
			$role->get_role_id(),
			$role->get_expires() ? DateParser::dateToString( $role->get_expires() ) : null,
		);
	}
}
