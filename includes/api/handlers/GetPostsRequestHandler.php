<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PostMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Post;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetPostsByIdUseCase;

class GetPostsRequestHandler implements RequestHandler {
	private GetPostsByIdUseCase $get_posts_by_id_use_case;

	public function __construct(
		GetPostsByIdUseCase $get_posts_by_id_use_case
	) {
		$this->get_posts_by_id_use_case = $get_posts_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_POSTS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of posts, increase the timeout to 10min
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

		Logger::debug( "Sending posts for ids " . json_encode( $ids ) );

		$posts = $this->get_posts_by_id_use_case->invoke( $ids );

		$post_dtos = array_map(
			function ( Post $post ) {
				return PostMapper::to_dto( $post );
			},
			$posts
		);

		return PluginResponse::plugin_response()->body( $post_dtos );
	}
}