<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Wp\WPTagManager;

class GetTagsByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Tag[]
	 */
	public function invoke( array $ids ): array {
		return WPTagManager::get_tags_by_id( $ids );
	}
}