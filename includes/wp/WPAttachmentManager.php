<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\Mapper\AttachmentMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Post;

class WPAttachmentManager {
	public static function get_thumbnail_for_post_id( int $post_id ): ?Attachment {
		if ( ! has_post_thumbnail( $post_id ) ) {
			return null;
		}

		$thumbnail_id = get_post_thumbnail_id( $post_id );

		if ( ! $thumbnail_id || $thumbnail_id == 0 ) {
			return null;
		}

		$attachment = get_post( $thumbnail_id );
		if ( $attachment == null ) {
			return null;
		}

		return AttachmentMapper::to_domain( $attachment );
	}

	public static function get_image_for_term_id( int $term_id ): ?Attachment {
		$term_image_id = get_term_meta( $term_id, Constants::$APPFUL_TERM_IMAGE_META_KEY, true );

		if ( ! $term_image_id || $term_image_id == "" ) {
			return null;
		}

		$attachment = get_post( $term_image_id );
		if ( $attachment == null ) {
			return null;
		}

		return AttachmentMapper::to_domain( $attachment );
	}

	/** @return Attachment[] */
	public static function get_attachments_for_post_id( int $post_id ): array {
		$attachments = get_attached_media( 'image', $post_id );
		$attachments = array_values( $attachments );

		return array_map(
			function ( WP_Post $attachment ) {
				return AttachmentMapper::to_domain( $attachment );
			},
			$attachments
		);
	}

	public static function get_attachment_language( int $attachment_id ): string {
		return LanguageHelper::get_attachment_language( $attachment_id );
	}

	public static function get_meta_for_attachment( int $attachment_id ) {
		return wp_get_attachment_metadata( $attachment_id );
	}

	public static function get_url_for_attachment( int $attachment_id ): string {
		$url = wp_get_attachment_url( $attachment_id );
		if ( ! $url ) {
			return "";
		}

		return $url;
	}

	public static function get_attachment_count(): int {
		return WPPostDatabaseManager::get_count_for_type( "attachment" );
	}

	/** @return SyncItem[] */
	public static function get_attachment_sync_items( int $offset, int $count ): array {
		return WPPostDatabaseManager::get_sync_items_for_type( "attachment", $count, $offset );
	}

	/**
	 * @param int[] $ids
	 *
	 * @return Attachment[]
	 */
	public static function get_attachments_by_id( array $ids ): array {
		$args = [
			"post_type"   => "attachment",
			"include"     => $ids,
			"numberposts" => - 1
		];

        $all_attachments = LanguageHelper::for_each_language( function () use ( $args ) {
            return get_posts( $args );
        } );

		$all_attachments = array_values(
			array_filter( $all_attachments, function ( WP_Post $attachment ) use ( $ids ) {
				return in_array( $attachment->ID, $ids );
			} )
		);

		return array_map(
			function ( WP_Post $attachment ) {
				return AttachmentMapper::to_domain( $attachment );
			},
			$all_attachments
		);
	}
}