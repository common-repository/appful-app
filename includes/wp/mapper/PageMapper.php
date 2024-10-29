<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Page;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\WPAttachmentManager;
use AppfulPlugin\Wp\WPPageManager;
use AppfulPlugin\Wp\WPRoleManager;
use AppfulPlugin\Wp\WPUserManager;
use WP_Post;

class PageMapper {
	public static function to_domain( WP_Post $page ): Page {
		$page_lang = WPPageManager::get_page_language( $page->ID );

		return Page::page()
		           ->id( $page->ID )
		           ->title( $page->post_title )
		           ->status( $page->post_status )
		           ->url( WPPageManager::get_page_permalink( $page ) )
		           ->author( WPUserManager::get_user_by_id( $page->post_author ) )
		           ->thumbnail( WPAttachmentManager::get_thumbnail_for_post_id( $page->ID ) )
		           ->language( $page_lang )
		           ->modified( DateParser::fromGmtDate( $page->post_modified_gmt ) )
		           ->date( DateParser::fromGmtDate( $page->post_date_gmt ) )
		           ->comment_status( $page->comment_status )
		           ->roles( WPRoleManager::get_roles_for_page_id( $page->ID ) );
	}
}
