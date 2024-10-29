<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPCommentManager;

class GetCommentSyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke( int $offset, int $count ): array {
		return WPCommentManager::get_comment_sync_items( $offset, $count );
	}
}
