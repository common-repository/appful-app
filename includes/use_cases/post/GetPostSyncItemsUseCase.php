<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPPostManager;

class GetPostSyncItemsUseCase {
	/** @return SyncItem[] */
	public function invoke( int $offset, int $count ): array {
		return WPPostManager::get_post_sync_items( $offset, $count );
	}
}
