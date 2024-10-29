<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\SyncUsersUseCase;

class UserSyncRequestHandler implements RequestHandler {
	private SyncUsersUseCase $sync_users_use_case;

	public function __construct(
		SyncUsersUseCase $sync_users_use_case
	) {
		$this->sync_users_use_case = $sync_users_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$SYNC_USERS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of users, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		$this->sync_users_use_case->invoke();

		return PluginResponse::plugin_response()->status( 200 );
	}
}