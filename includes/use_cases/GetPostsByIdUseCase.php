<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Post;
use AppfulPlugin\Wp\WPPostManager;

class GetPostsByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Post[]
	 */
	public function invoke( array $ids ): array {
		return WPPostManager::get_posts_by_id( $ids );
	}
}