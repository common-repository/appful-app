<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Role;
use AppfulPlugin\Wp\WPRoleManager;

class GetRoleSyncDataUseCase {
	/** @return Role[] */
	public function invoke(): array {
		return WPRoleManager::get_all_roles();
	}
}
