<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\ClearLogsUseCase;

class ClearLogRequestHandler implements RequestHandler {
	private ClearLogsUseCase $clear_logs_use_case;

	public function __construct( ClearLogsUseCase $clear_logs_use_case ) {
		$this->clear_logs_use_case = $clear_logs_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$CLEAR_LOGS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		$this->clear_logs_use_case->invoke();

		return PluginResponse::plugin_response();
	}
}
