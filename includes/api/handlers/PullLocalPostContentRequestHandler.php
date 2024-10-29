<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PostContentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetLocalPostContentByIdUseCase;

class PullLocalPostContentRequestHandler implements RequestHandler {
	private GetLocalPostContentByIdUseCase $get_local_post_content_by_id_use_case;

	public function __construct(
		GetLocalPostContentByIdUseCase $get_local_post_content_by_id_use_case
	) {
		$this->get_local_post_content_by_id_use_case = $get_local_post_content_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_POST_CONTENT_LOCAL;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of posts, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		if ( ! isset( $_GET['id'] ) ) {
			return PluginResponse::plugin_response()->status( 400 );
		}

		$cleanedId = absint( sanitize_text_field( $_GET['id'] ) );

		Logger::debug( "Sending local post content for id " . $cleanedId );

		$post_content = $this->get_local_post_content_by_id_use_case->invoke( $cleanedId );
		if ( $post_content == null ) {
			return PluginResponse::plugin_response()->status( 404 );
		}

		$post_content_dto = PostContentMapper::to_dto( $post_content );

		return PluginResponse::plugin_response()->body( $post_content_dto );
	}
}
