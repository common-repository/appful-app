<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\RoleMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Role;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetRolesByIdUseCase;

class GetRolesRequestHandler implements RequestHandler {
	private GetRolesByIdUseCase $get_roles_by_id_use_case;

	public function __construct(
		GetRolesByIdUseCase $get_roles_by_id_use_case
	) {
		$this->get_roles_by_id_use_case = $get_roles_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_ROLES;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of roles, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		if ( ! isset( $_GET['ids'] ) ) {
			return PluginResponse::plugin_response()->status( 400 );
		}

		$cleanedIds = sanitize_text_field( $_GET['ids'] );
		$ids        = array_map(
			function ( $id ) {
				return absint( $id );
			},
			explode( ",", $cleanedIds )
		);

		Logger::debug( "Sending roles for ids " . json_encode( $ids ) );

		$roles = $this->get_roles_by_id_use_case->invoke( $ids );

		$role_dtos = array_map(
			function ( Role $role ) {
				return RoleMapper::to_dto( $role );
			},
			$roles
		);

		return PluginResponse::plugin_response()->body( $role_dtos );
	}
}