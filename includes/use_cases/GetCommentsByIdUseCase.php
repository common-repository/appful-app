<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Wp\WPCommentManager;

class GetCommentsByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Comment[]
	 */
	public function invoke( array $ids ): array {
		return WPCommentManager::get_comments_by_id( $ids );
	}
}