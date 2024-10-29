<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\WPPostManager;

class GetTaxonomyPostSyncItemsUseCase {
	/** @return SyncItem[] */
	public function invoke( string $taxonomy, string $term_slug, int $offset, int $count ): array {
		return WPPostManager::get_taxonomy_post_sync_items( $taxonomy, $term_slug, $offset, $count );
	}
}
