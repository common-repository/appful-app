<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPPageManager;

class GetPageSyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke( int $offset, int $count ): array {
		return WPPageManager::get_page_sync_items( $offset, $count );
	}
}
