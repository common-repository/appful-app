<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\Role;
use AppfulPlugin\Wp\Plugins\RoleHelper;

class WPRoleManager {
	/** @return Role[] */
	public static function get_roles_for_post_id( int $post_id ): array {
		return RoleHelper::get_post_user_roles( $post_id );
	}

	/** @return Role[] */
	public static function get_roles_for_page_id( int $page_id ): array {
		return RoleHelper::get_page_user_roles( $page_id );
	}

	/** @return Role[] */
	public static function get_all_roles(): array {
		return RoleHelper::get_all_roles();
	}

	/**
	 * @param int[] $ids
	 *
	 * @return Role[]
	 */
	public static function get_roles_by_id( array $ids ): array {
		return RoleHelper::get_roles_by_id( $ids );
	}
}
