<?php

namespace AppfulPlugin\CustomTaxonomies;

class TaxonomyManager {
	private AppfulTaxonomies $taxonomy;

	public function __construct() {
		$this->taxonomy = new AppfulTaxonomies();
	}

	public function add_initial_taxonomies() {
		$this->taxonomy->add_appful_taxonomy_items();
	}

	public function remove_initial_taxonomies() {
		$this->taxonomy->remove_appful_taxonomy_items();
	}

	public function load_direct() {
		$this->taxonomy->load();
	}

	public function load() {
		add_action(
			"init",
			function () {
				$this->taxonomy->load();
			},
			10,
			0
		);
	}
}