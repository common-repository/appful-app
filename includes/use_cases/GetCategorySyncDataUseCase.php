<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPCategoryManager;

class GetCategorySyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke(): array {
		return WPCategoryManager::get_category_sync_items();
	}
}