<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Wp\Mapper\TagMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Error;
use WP_Term;

class WPTagManager {
	public static function get_tag_language( int $term_id ): string {
		return LanguageHelper::get_tag_language( $term_id );
	}

	/** @return Tag[] */
	public static function get_tags_for_post_id( int $post_id, string $lang ): array {
		$post_tags = LanguageHelper::for_language( $lang, function () use ( $post_id ) {
			return get_the_tags( $post_id );
		} );

		if ( ! $post_tags || $post_tags instanceof WP_Error ) {
			return [];
		}

		return array_map(
			function ( WP_Term $term ) {
				return TagMapper::to_domain( $term );
			},
			$post_tags
		);
	}

	/** @return SyncItem[] */
	public static function get_tag_sync_items(): array {
		$args = [
			"taxonomy"   => "post_tag",
			"hide_empty" => false
		];

		$all_tags = LanguageHelper::for_each_language( function () use ( $args ) {
			return get_terms( $args );
		} );

		return array_map(
			function ( WP_Term $tag ) {
				return SyncItem::syncItem()
				               ->id( $tag->term_id );
			},
			$all_tags
		);
	}

	/**
	 * @param int[] $ids
	 *
	 * @return Tag[]
	 */
	public static function get_tags_by_id( array $ids ): array {
		$args = [
			"taxonomy"   => "post_tag",
			"hide_empty" => false,
			"include"    => $ids
		];

		$all_tags = LanguageHelper::for_each_language( function () use ( $args ) {
			return get_terms( $args );
		} );

		$all_tags = array_values(
			array_filter( $all_tags, function ( WP_Term $tag ) use ( $ids ) {
				return in_array( $tag->term_id, $ids );
			} )
		);

		return array_map(
			function ( WP_Term $tag ) {
				return TagMapper::to_domain( $tag );
			},
			$all_tags
		);
	}
}