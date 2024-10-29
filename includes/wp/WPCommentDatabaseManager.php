<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\SyncItem;

class WPCommentDatabaseManager {
	/** @return SyncItem[] */
	public static function get_sync_items( int $limit, int $offset ): array {
		global $wpdb;

		$query   = $wpdb->prepare( "SELECT comment.comment_ID FROM $wpdb->comments AS comment ORDER BY comment.comment_ID DESC LIMIT %d OFFSET %d", $limit, $offset );
		$results = $wpdb->get_results( $query );

		return array_map(
			function ( $item ) {
				return SyncItem::syncItem()
				               ->id( $item->comment_ID );
			},
			$results
		);
	}

	public static function get_count(): int {
		global $wpdb;

		return $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->comments" );
	}
}
