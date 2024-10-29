<?php

namespace AppfulPlugin\CustomTaxonomies;

use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class AppfulTaxonomies {
	public function load(): void {
		$this->load_appful_taxonomy();
	}

	private function load_appful_taxonomy() {
		$labels = array(
			"name"              => __( "Appful" ),
			"singular_name"     => __( "Appful" ),
			"search_items"      => __( "Search Appful settings" ),
			"all_items"         => __( "All Appful settings" ),
			"parent_item"       => __( "Parent setting" ),
			"parent_item_colon" => __( "Parent setting:" ),
			"edit_item"         => __( "Edit setting" ),
			"view_item"         => __( "View setting" ),
			"update_item"       => __( "Update settings" ),
			"add_new_item"      => __( "Add new setting" ),
			"new_item_name"     => __( "New Appful setting" ),
			"menu_name"         => __( "Appful" ),
		);
		$args   = array(
			"description"        => "All the settings used by the Appful plugin",
			"labels"             => $labels,
			"hierarchical"       => true,
			"public"             => true,
			"show_ui"            => true,
			"show_in_menu"       => false,
			"show_in_nav_menus"  => false,
			"show_tagcloud"      => false,
			"show_in_rest"       => true,
			"show_in_quick_edit" => true,
			"capabilities"       => [
				"manage_terms" => "god",
				"edit_terms"   => "god",
				"delete_terms" => "god",
				"assign_terms" => "edit_posts"
			],
			"default_term"       => [
				[
					"name"        => Constants::$APPFUL_TAXONOMY_PUSH_TERM_NAME,
					"slug"        => Constants::$APPFUL_TAXONOMY_PUSH_TERM_SLUG,
					"description" => "Don't send notifications about new posts"
				]
			]
		);

		register_taxonomy(
			Constants::$APPFUL_TAXONOMY_NAME,
			[ "post" ],
			$args
		);
	}

	public function add_appful_taxonomy_items() {
		$push_term = get_term_by( "slug", Constants::$APPFUL_TAXONOMY_PUSH_TERM_SLUG, Constants::$APPFUL_TAXONOMY_NAME );

		if ( ! $push_term ) {
			Logger::debug( "Adding initial appful push term" );

			$args = [
				"description" => "Don't send notifications about new posts",
				"slug"        => Constants::$APPFUL_TAXONOMY_PUSH_TERM_SLUG
			];

			wp_insert_term(
				Constants::$APPFUL_TAXONOMY_PUSH_TERM_NAME,
				Constants::$APPFUL_TAXONOMY_NAME,
				$args
			);
		}
	}

	public function remove_appful_taxonomy_items() {
		$push_term = get_term_by( "slug", Constants::$APPFUL_TAXONOMY_PUSH_TERM_SLUG, Constants::$APPFUL_TAXONOMY_NAME );

		if ( $push_term ) {
			Logger::info( "Removing initial appful push term" );

			wp_delete_term(
				$push_term->term_id,
				Constants::$APPFUL_TAXONOMY_NAME,
			);
		}
	}
}