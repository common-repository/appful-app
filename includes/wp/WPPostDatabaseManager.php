<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\PointOfInterest\PointOfInterest;
use AppfulPlugin\Domain\PointOfInterest\PostPointOfInterest;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\Entities\PostCoordinatesEntity;

class WPPostDatabaseManager {
	/** @return SyncItem[] */
	public static function get_sync_items_for_type( string $type, int $limit, int $offset ): array {
		global $wpdb;

		$query   = $wpdb->prepare( "SELECT post.ID, post.post_modified_gmt FROM $wpdb->posts AS post WHERE post.post_type = %s ORDER BY post.ID DESC LIMIT %d OFFSET %d", $type, $limit, $offset );
		$results = $wpdb->get_results( $query );

		return array_map(
			function ( $item ) {
				return SyncItem::syncItem()
				               ->id( $item->ID )
				               ->modified( DateParser::fromGmtDate( $item->post_modified_gmt ) );
			},
			$results
		);
	}

	/** @return SyncItem[] */
	public static function get_sync_items_for_type_and_taxonomy( string $type, string $taxonomy, string $term_slug, int $limit, int $offset ): array {
		global $wpdb;

		$query   = $wpdb->prepare( "SELECT post.ID, post.post_modified_gmt FROM $wpdb->posts AS post INNER JOIN $wpdb->term_relationships AS term_rel ON post.ID = term_rel.object_id INNER JOIN $wpdb->term_taxonomy AS term_tax ON term_rel.term_taxonomy_id = term_tax.term_taxonomy_id INNER JOIN $wpdb->terms AS term ON term_tax.term_id = term.term_id WHERE post.post_type = %s AND term_tax.taxonomy = %s AND term.slug = %s ORDER BY post.ID DESC LIMIT %d OFFSET %d", $type, $taxonomy, $term_slug, $limit, $offset );
		$results = $wpdb->get_results( $query );

		return array_map(
			function ( $item ) {
				return SyncItem::syncItem()
				               ->id( $item->ID )
				               ->modified( DateParser::fromGmtDate( $item->post_modified_gmt ) );
			},
			$results
		);
	}

	public static function get_sync_item_for_type( string $type, int $id ): SyncItem {
		global $wpdb;

		$query  = $wpdb->prepare( "SELECT post.ID, post.post_modified_gmt FROM $wpdb->posts AS post WHERE post.post_type = %s AND post.ID = %d", $type, $id );
		$result = $wpdb->get_row( $query );

		return SyncItem::syncItem()
		               ->id( $result->ID )
		               ->modified( DateParser::fromGmtDate( $result->post_modified_gmt ) );
	}

	public static function get_count_for_type( string $type ): int {
		global $wpdb;

		$query = $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts AS post WHERE post.post_type = %s", $type );

		return $wpdb->get_var( $query );
	}

	public static function get_count_for_type_and_taxonomy( string $type, string $taxonomy, string $term_slug ): int {
		global $wpdb;

		$query = $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts AS post INNER JOIN $wpdb->term_relationships AS term_rel ON post.ID = term_rel.object_id INNER JOIN $wpdb->term_taxonomy AS term_tax ON term_rel.term_taxonomy_id = term_tax.term_taxonomy_id INNER JOIN $wpdb->terms AS term ON term_tax.term_id = term.term_id WHERE post.post_type = %s AND term_tax.taxonomy = %s AND term.slug = %s", $type, $taxonomy, $term_slug );

		return $wpdb->get_var( $query );
	}

	/**
	 * @param int[] $ids
	 *
	 * @return PointOfInterest[]
	 */
	public static function get_points_of_interest_for_ids( array $ids ): array {
		global $wpdb;

		if ( empty( $ids ) ) {
			return [];
		}

		$commaDelimitedIds = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
		$query             = $wpdb->prepare( "SELECT post.ID, post.post_title, post.post_modified_gmt, meta.meta_value FROM $wpdb->posts AS post INNER JOIN $wpdb->postmeta AS meta ON post.ID = meta.post_id WHERE post.ID IN($commaDelimitedIds) AND meta.meta_key = %s ORDER BY post.ID DESC", array_merge( $ids, [ Constants::$APPFUL_POST_META_COORDINATES_KEY ] ) );
		$results           = $wpdb->get_results( $query );

		return array_map(
			function ( $item ) {
				$coordinates_object = json_decode( $item->meta_value );
				$coordinates        = new PostCoordinatesEntity(null, 0, 0 );
				if ( $coordinates_object ) {
					$coordinates = new PostCoordinatesEntity( $coordinates_object->name, $coordinates_object->latitude, $coordinates_object->longitude );
				}

				return new PostPointOfInterest(
					$item->ID,
                    $coordinates->name ?? $item->post_title,
					$coordinates->longitude,
					$coordinates->latitude,
					DateParser::fromGmtDate( $item->post_modified_gmt ),
					$item->ID
				);
			},
			$results
		);
	}
}
