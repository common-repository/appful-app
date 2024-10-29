<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Api\Rewrites;
use AppfulPlugin\CustomTaxonomies\TaxonomyManager;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\WPOptionsManager;

class ActivationHook {
	private string $PLUGIN_NAME;

	private Rewrites $appful_rewrites;
	private UseCaseManager $use_case_manager;
	private TaxonomyManager $taxonomy_manager;

	public function __construct( Rewrites $appful_rewrites, UseCaseManager $use_case_manager, TaxonomyManager $taxonomy_manager ) {
		$this->PLUGIN_NAME      = WP_PLUGIN_DIR . Constants::$PLUGIN_ROOT_DIR . Constants::$PLUGIN_ROOT_FILE;
		$this->appful_rewrites  = $appful_rewrites;
		$this->use_case_manager = $use_case_manager;
		$this->taxonomy_manager = $taxonomy_manager;
	}

	public function init() {
		register_activation_hook(
			$this->PLUGIN_NAME,
			function () {
				$this->on_activate();
			}
		);
		register_deactivation_hook(
			$this->PLUGIN_NAME,
			function () {
				$this->on_deactivate();
			}
		);
	}

	private function on_activate() {
		Logger::info( "Plugin activated" );

		$this->taxonomy_manager->load_direct();
		$this->taxonomy_manager->add_initial_taxonomies();
	}

	private function on_deactivate() {
		Logger::info( "Plugin deactivated" );

		$this->taxonomy_manager->load_direct();
		$this->taxonomy_manager->remove_initial_taxonomies();

		$this->appful_rewrites->disable_rewrite();
		if ( $this->use_case_manager->is_logged_in_use_case()->invoke() ) {
			$this->use_case_manager->delete_session_use_case()->invoke();
			$this->use_case_manager->logout_user_use_case()->invoke();
		}
		WPOptionsManager::clean();
	}
}
