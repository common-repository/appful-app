<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\CommentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetCommentsByIdUseCase;

class GetCommentsRequestHandler implements RequestHandler {
	private GetCommentsByIdUseCase $get_comments_by_id_use_case;

	public function __construct(
		GetCommentsByIdUseCase $get_comments_by_id_use_case
	) {
		$this->get_comments_by_id_use_case = $get_comments_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_COMMENTS;
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

		Logger::debug( "Sending comments for ids " . json_encode( $ids ) );

		$comments = $this->get_comments_by_id_use_case->invoke( $ids );

		$comment_dtos = array_map(
			function ( Comment $comment ) {
				return CommentMapper::to_dto( $comment );
			},
			$comments
		);

		return PluginResponse::plugin_response()->body( $comment_dtos );
	}
}