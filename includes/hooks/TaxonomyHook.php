<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\Mapper\CategoryMapper;
use AppfulPlugin\Wp\Mapper\TagMapper;

class TaxonomyHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"saved_category",
			function ( int $term_id, int $taxonomy_id ) {
				$this->on_saved_category( $term_id, $taxonomy_id );
			},
			10,
			2,
		);

		add_action(
			"delete_category",
			function ( int $term_id, int $taxonomy_id ) {
				$this->on_delete_category( $term_id, $taxonomy_id );
			},
			10,
			2,
		);

		add_action(
			"saved_post_tag",
			function ( int $term_id, int $taxonomy_id ) {
				$this->on_saved_tag( $term_id, $taxonomy_id );
			},
			10,
			2,
		);

		add_action(
			"delete_post_tag",
			function ( int $term_id, int $taxonomy_id ) {
				$this->on_delete_tag( $term_id, $taxonomy_id );
			},
			10,
			2,
		);
	}

	private function on_saved_category( int $term_id, int $taxonomy_id ) {
		$category = get_term( $term_id );
		Logger::debug( "Category with id " . $term_id . " saved!" );

		$domain_category = CategoryMapper::to_domain( $category );
		$this->use_case_manager->category_save_use_case()->invoke( $domain_category );
	}

	private function on_delete_category( int $term_id, int $taxonomy_id ) {
		Logger::debug( "Category with id " . $term_id . " deleted!" );

		$this->use_case_manager->category_delete_use_case()->invoke( $term_id );
	}

	private function on_saved_tag( int $term_id, int $taxonomy_id ) {
		$tag = get_term( $term_id );
		Logger::debug( "Tag with id " . $term_id . " saved!" );

		$domain_tag = TagMapper::to_domain( $tag );
		$this->use_case_manager->tag_save_use_case()->invoke( $domain_tag );
	}

	private function on_delete_tag( int $term_id, int $taxonomy_id ) {
		Logger::debug( "Tag with id " . $term_id . " deleted!" );

		$this->use_case_manager->tag_delete_use_case()->invoke( $term_id );
	}
}