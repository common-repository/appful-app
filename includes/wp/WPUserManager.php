<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Domain\User;
use AppfulPlugin\Domain\UserRole;
use AppfulPlugin\Wp\Mapper\UserMapper;
use AppfulPlugin\Wp\Plugins\RoleHelper;
use WP_User;

class WPUserManager {
	public static function get_user_avatar( int $user_id ): string {
		$avatar_url = get_avatar_url( $user_id );

		if ( ! $avatar_url ) {
			return "";
		}

		return $avatar_url;
	}

	/** @return UserRole[] */
	public static function get_user_roles( int $user_id ): array {
		return RoleHelper::get_user_roles( $user_id );
	}

	public static function get_user_by_id( int $user_id ): ?User {
		$user = get_user_by( "id", $user_id );

		if ( ! $user ) {
			return null;
		}

		return UserMapper::to_domain( $user );
	}

	public static function authenticate( string $username, string $password ): ?int {
		$credentials = [
			'user_login'    => $username,
			'user_password' => $password,
			'remember'      => false,
		];

		$user = wp_signon( $credentials, false );
		if ( is_wp_error( $user ) ) {
			return null;
		} else {
			return $user->ID;
		}
	}

	public static function get_user_count(): int {
		return WPUserDatabaseManager::get_count();
	}

	/** @return SyncItem[] */
	public static function get_user_sync_items( int $offset, int $count ): array {
		return WPUserDatabaseManager::get_sync_items( $count, $offset );
	}

	/**
	 * @param int[] $ids
	 *
	 * @return User[]
	 */
	public static function get_users_by_id( array $ids ): array {
		$args = [
			"include" => $ids
		];

		$all_users = get_users( $args );

		return array_map(
			function ( WP_User $user ) {
				return UserMapper::to_domain( $user );
			},
			$all_users
		);
	}
}