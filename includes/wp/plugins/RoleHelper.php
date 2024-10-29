<?php

namespace AppfulPlugin\Wp\Plugins;

use AppfulPlugin\Domain\Role;
use AppfulPlugin\Domain\UserRole;

class RoleHelper {
	/** @return UserRole[] */
	public static function get_user_roles( int $user_id ): array {
		return apply_filters( "appful_user_roles", [], $user_id );
	}

	/** @return Role[] */
	public static function get_all_roles(): array {
		return apply_filters( "appful_roles", [] );
	}

	/**
	 * @param int[] $ids
	 *
	 * @return Role[]
	 */
	public static function get_roles_by_id( array $ids ): array {
		return apply_filters( "appful_roles_by_ids", [], $ids );
	}

	/** @return Role[] */
	public static function get_post_user_roles( int $post_id ): array {
		return apply_filters( "appful_element_user_roles", [], $post_id );
	}

	/** @return Role[] */
	public static function get_page_user_roles( int $page_id ): array {
		return apply_filters( "appful_element_user_roles", [], $page_id );
	}
}
