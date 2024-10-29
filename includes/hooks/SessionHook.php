<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\WPOptionsManager;

class SessionHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"appful_login",
			function () {
				$this->on_appful_login();
			},
			10,
			0
		);

		add_action(
			"appful_logout",
			function () {
				$this->on_appful_logout();
			},
			10,
			0
		);
	}

	private function on_appful_login() {
		Logger::info( "Logging in user!" );

		WPOptionsManager::delete_last_sync_error();

		if ( $this->use_case_manager->register_blog_use_case()->invoke() ) {
			$this->use_case_manager->sync_all_use_case()->invoke();
		} else {
			Logger::error( "Error occurred when registering blog!" );
			$this->clean_on_error();
		}
	}

	private function clean_on_error() {
		if ( $this->use_case_manager->is_logged_in_use_case()->invoke() ) {
			$this->use_case_manager->logout_user_use_case()->invoke();
		}

		WPOptionsManager::clean();
	}

	private function on_appful_logout() {
		Logger::info( "Logging out user!" );
		if ( $this->use_case_manager->is_logged_in_use_case()->invoke() ) {
			$this->use_case_manager->delete_session_use_case()->invoke();
			$this->use_case_manager->logout_user_use_case()->invoke();
		}

		WPOptionsManager::clean();
	}
}
