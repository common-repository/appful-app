<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetLogsUseCase;

class LogRequestHandler implements RequestHandler {
	private GetLogsUseCase $get_logs_use_case;

	public function __construct( GetLogsUseCase $get_logs_use_case ) {
		$this->get_logs_use_case = $get_logs_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$LOGS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		$logs = $this->get_logs_use_case->invoke();

		return PluginResponse::plugin_response()->body( $logs )->encoded( false );
	}
}