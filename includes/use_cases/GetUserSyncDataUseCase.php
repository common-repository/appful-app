<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPUserManager;

class GetUserSyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke( int $offset, int $count ): array {
		return WPUserManager::get_user_sync_items( $offset, $count );
	}
}