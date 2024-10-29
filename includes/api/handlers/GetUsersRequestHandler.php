<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\UserMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\User;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetUsersByIdUseCase;

class GetUsersRequestHandler implements RequestHandler {
	private GetUsersByIdUseCase $get_users_by_id_use_case;

	public function __construct(
		GetUsersByIdUseCase $get_users_by_id_use_case
	) {
		$this->get_users_by_id_use_case = $get_users_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_USERS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of users, increase the timeout to 10min
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

		Logger::debug( "Sending users for ids " . json_encode( $ids ) );

		$users = $this->get_users_by_id_use_case->invoke( $ids );

		$user_dtos = array_map(
			function ( User $user ) {
				return UserMapper::to_dto( $user );
			},
			$users
		);

		return PluginResponse::plugin_response()->body( $user_dtos );
	}
}
