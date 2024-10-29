<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Role;
use AppfulPlugin\Wp\WPRoleManager;

class GetRolesByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Role[]
	 */
	public function invoke( array $ids ): array {
		return WPRoleManager::get_roles_by_id( $ids );
	}
}
