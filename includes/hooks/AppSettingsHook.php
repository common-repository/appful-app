<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Domain\App\AppAdBanner;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;

class AppSettingsHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"appful_app_update_ad_banner",
			function ( string $image_url, string $target_link ) {
				$this->on_update_ad_banner( $image_url, $target_link );
			},
			10,
			2,
		);
	}

	private function on_update_ad_banner( string $image_url, string $target_link ) {
		Logger::debug( "Update ad banner with image " . $image_url . " and target " . $target_link );

		$ad_banner_settings = AppAdBanner::init()
		                                 ->image_url( $image_url )
		                                 ->target_link( $target_link );

		$this->use_case_manager->app_settings()->get_update_app_ad_banner_use_case()->invoke( $ad_banner_settings );
	}
}
