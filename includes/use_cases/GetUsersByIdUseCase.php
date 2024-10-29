<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\User;
use AppfulPlugin\Wp\WPUserManager;

class GetUsersByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return User[]
	 */
	public function invoke( array $ids ): array {
		return WPUserManager::get_users_by_id( $ids );
	}
}