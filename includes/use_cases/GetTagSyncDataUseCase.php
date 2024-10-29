<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPTagManager;

class GetTagSyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke(): array {
		return WPTagManager::get_tag_sync_items();
	}
}