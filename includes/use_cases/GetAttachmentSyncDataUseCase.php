<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPAttachmentManager;

class GetAttachmentSyncDataUseCase {
	/** @return SyncItem[] */
	public function invoke(int $offset, int $count): array {
		return WPAttachmentManager::get_attachment_sync_items($offset, $count);
	}
}
