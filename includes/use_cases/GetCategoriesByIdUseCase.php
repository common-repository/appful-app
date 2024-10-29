<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Category;
use AppfulPlugin\Wp\WPCategoryManager;

class GetCategoriesByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return Category[]
	 */
	public function invoke( array $ids ): array {
		return WPCategoryManager::get_categories_by_id( $ids );
	}
}