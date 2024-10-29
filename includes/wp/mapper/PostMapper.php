<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Post;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\WPAttachmentManager;
use AppfulPlugin\Wp\WPCategoryManager;
use AppfulPlugin\Wp\WPPostManager;
use AppfulPlugin\Wp\WPRoleManager;
use AppfulPlugin\Wp\WPTagManager;
use AppfulPlugin\Wp\WPUserManager;
use WP_Post;

class PostMapper {
	public static function to_domain( WP_Post $post ): Post {
		$post_lang = WPPostManager::get_post_language( $post->ID );

		return Post::post()
		           ->id( $post->ID )
		           ->title( $post->post_title )
		           ->status( $post->post_status )
		           ->url( WPPostManager::get_post_permalink( $post ) )
		           ->author( WPUserManager::get_user_by_id( $post->post_author ) )
		           ->categories( WPCategoryManager::get_categories_for_post_id( $post->ID, $post_lang ) )
		           ->tags( WPTagManager::get_tags_for_post_id( $post->ID, $post_lang ) )
		           ->thumbnail( WPAttachmentManager::get_thumbnail_for_post_id( $post->ID ) )
		           ->attachments( WPAttachmentManager::get_attachments_for_post_id( $post->ID ) )
		           ->language( $post_lang )
		           ->modified( DateParser::fromGmtDate( $post->post_modified_gmt ) )
		           ->date( DateParser::fromGmtDate( $post->post_date_gmt ) )
		           ->comment_status( $post->comment_status )
		           ->sticky( WPPostManager::is_post_sticky( $post->ID ) )
		           ->send_push( WPPostManager::should_send_push( $post->ID ) )
		           ->roles( WPRoleManager::get_roles_for_post_id( $post->ID ) );
	}

	public static function to_sync_item( WP_Post $post, bool $force_update ): SyncItem {
		return SyncItem::syncItem()
		               ->id( $post->ID )
		               ->modified( DateParser::fromGmtDate( $post->post_modified_gmt ) )
		               ->force_update( $force_update );
	}
}
