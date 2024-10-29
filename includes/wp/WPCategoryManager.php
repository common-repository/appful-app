<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\Category;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\Mapper\CategoryMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Term;

class WPCategoryManager {
	public static function get_category_language( int $term_id ): string {
		return LanguageHelper::get_category_language( $term_id );
	}

	/** @return Category[] */
	public static function get_categories_for_post_id( int $post_id, string $lang ): array {
		$post_categories = LanguageHelper::for_language( $lang, function () use ( $post_id ) {
			return get_the_category( $post_id );
		} );

		if ( ! $post_categories || $post_categories instanceof WP_Error ) {
			return [];
		}

		return array_map(
			function ( WP_Term $term ) {
				return CategoryMapper::to_domain( $term );
			},
			$post_categories
		);
	}

	/** @return SyncItem[] */
	public static function get_category_sync_items(): array {
		$args = [
			"taxonomy"   => "category",
			"hide_empty" => false
		];

		$all_categories = LanguageHelper::for_each_language( function () use ( $args ) {
			return get_terms( $args );
		} );

		return array_map(
			function ( WP_Term $category ) {
				return SyncItem::syncItem()
				               ->id( $category->term_id );
			},
			$all_categories
		);
	}

	/**
	 * @param int[] $ids
	 *
	 * @return Category[]
	 */
	public static function get_categories_by_id( array $ids ): array {
		$args = [
			"taxonomy"   => "category",
			"hide_empty" => false,
			"include"    => $ids
		];

		$all_categories = LanguageHelper::for_each_language( function () use ( $args ) {
			return get_terms( $args );
		} );

		$all_categories = array_values(
			array_filter( $all_categories, function ( WP_Term $category ) use ( $ids ) {
				return in_array( $category->term_id, $ids );
			} )
		);

		return array_map(
			function ( WP_Term $category ) {
				return CategoryMapper::to_domain( $category );
			},
			$all_categories
		);
	}
}