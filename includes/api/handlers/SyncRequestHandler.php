<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\SyncAllUseCase;

class SyncRequestHandler implements RequestHandler {
	private SyncAllUseCase $sync_all_use_case;

	public function __construct(
		SyncAllUseCase $sync_all_use_case
	) {
		$this->sync_all_use_case = $sync_all_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$SYNC;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		$this->sync_all_use_case->invoke();

		return PluginResponse::plugin_response()->status( 200 );
	}
}