<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Wp\WPAttachmentManager;

class GetAttachmentsByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Attachment[]
	 */
	public function invoke( array $ids ): array {
		return WPAttachmentManager::get_attachments_by_id( $ids );
	}
}