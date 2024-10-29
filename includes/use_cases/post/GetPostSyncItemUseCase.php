<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPPostManager;

class GetPostSyncItemUseCase {
	public function invoke( int $post_id ): SyncItem {
		return WPPostManager::get_post_sync_item( $post_id );
	}
}
