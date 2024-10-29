<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\User;
use AppfulPlugin\Wp\WPAuthorManager;
use AppfulPlugin\Wp\WPUserManager;
use WP_User;

class UserMapper {
	public static function to_domain( WP_User $user ): User {
		$first_name = $user->first_name;
		if ( ! $first_name ) {
			$first_name = "";
		}

		$last_name = $user->last_name;
		if ( ! $last_name ) {
			$last_name = "";
		}

		$display_name = $user->display_name;
		if ( ! $display_name ) {
			$display_name = "";
		}

		return User::user()
		           ->id( $user->ID )
		           ->firstname( $first_name )
		           ->lastname( $last_name )
		           ->display_name( $display_name )
		           ->avatar( WPUserManager::get_user_avatar( $user->ID ) )
		           ->roles( WPUserManager::get_user_roles( $user->ID ) );
	}
}
