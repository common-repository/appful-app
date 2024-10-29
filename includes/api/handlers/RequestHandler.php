<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;

interface RequestHandler {
	public function can_handle_request( PluginRequest $request ): bool;

	public function handle_request( PluginRequest $request ): PluginResponse;
}