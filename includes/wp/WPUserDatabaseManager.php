<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\SyncItem;

class WPUserDatabaseManager {
	/** @return SyncItem[] */
	public static function get_sync_items( int $limit, int $offset ): array {
		global $wpdb;

		$query   = $wpdb->prepare( "SELECT user.ID FROM $wpdb->users AS user ORDER BY user.ID DESC LIMIT %d OFFSET %d", $limit, $offset );
		$results = $wpdb->get_results( $query );

		return array_map(
			function ( $item ) {
				return SyncItem::syncItem()
				               ->id( $item->ID );
			},
			$results
		);
	}

	public static function get_count(): int {
		global $wpdb;

		return $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->users" );
	}
}
