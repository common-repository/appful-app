<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\SyncCommentsUseCase;

class CommentSyncRequestHandler implements RequestHandler {
	private SyncCommentsUseCase $sync_comments_use_case;

	public function __construct(
		SyncCommentsUseCase $sync_comments_use_case
	) {
		$this->sync_comments_use_case = $sync_comments_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$SYNC_COMMENTS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of posts, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		$this->sync_comments_use_case->invoke();

		return PluginResponse::plugin_response()->status( 200 );
	}
}