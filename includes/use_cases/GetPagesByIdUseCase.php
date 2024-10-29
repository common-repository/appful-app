<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Page;
use AppfulPlugin\Wp\WPPageManager;

class GetPagesByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Page[]
	 */
	public function invoke( array $ids ): array {
		return WPPageManager::get_pages_by_id( $ids );
	}
}
