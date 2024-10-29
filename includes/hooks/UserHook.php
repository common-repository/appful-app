<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\WPUserManager;

class UserHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"user_register",
			function ( int $user_id ) {
				$this->on_save_user( $user_id );
			},
			10,
			1,
		);

		add_action(
			"profile_update",
			function ( int $user_id ) {
				$this->on_save_user( $user_id );
			},
			10,
			1,
		);

		add_action(
			"appful_user_roles_update",
			function ( int $user_id ) {
				$this->on_save_user( $user_id );
			},
			10,
			1,
		);

		add_action(
			"delete_user",
			function ( int $user_id ) {
				$this->on_delete_user( $user_id );
			},
			10,
			1,
		);
	}

	private function on_save_user( int $user_id ) {
		Logger::debug( "User with id " . $user_id . " saved!" );

		$wp_user = WPUserManager::get_user_by_id( $user_id );
		if ( $wp_user ) {
			$this->use_case_manager->user_save_use_case()->invoke( $wp_user );
		}
	}

	private function on_delete_user( int $user_id ) {
		Logger::debug( "User with id " . $user_id . " deleted!" );

		$this->use_case_manager->user_delete_use_case()->invoke( $user_id );
	}

}