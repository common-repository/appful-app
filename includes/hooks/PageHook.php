<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\Mapper\PageMapper;
use WP_Post;

class PageHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"wp_after_insert_post",
			function ( int $page_id, WP_Post $page ) {
				$this->after_save_page( $page );
			},
			99,
			2,
		);

		add_action(
			"delete_post",
			function ( int $page_id, WP_Post $page ) {
				$this->on_delete_page( $page_id, $page );
			},
			10,
			2
		);
	}

	private function on_delete_page( int $page_id, WP_Post $page ) {
		if ( $page->post_type != "page" ) {
			return;
		}

		Logger::debug( "Page with id " . $page->ID . " deleted!" );

		$this->use_case_manager->page_delete_use_case()->invoke( $page_id );
	}

	private function after_save_page( WP_Post $page ) {
		if ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( $page->post_type != "page" ) {
			return;
		}

		if ( $page->post_status == "auto-draft" || $page->post_status == "inherit" ) {
			return;
		}

		Logger::debug( "Page with id " . $page->ID . " inserted with status " . $page->post_status . "!" );

		$domain_page = PageMapper::to_domain( $page );
		$this->use_case_manager->page_save_use_case()->invoke( $domain_page );
	}
}
