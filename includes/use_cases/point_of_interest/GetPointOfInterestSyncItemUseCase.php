<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPPostManager;

class GetPointOfInterestSyncItemUseCase {
	public function invoke( int $poi_id ): SyncItem {
		return WPPostManager::get_post_sync_item( $poi_id );
	}
}
