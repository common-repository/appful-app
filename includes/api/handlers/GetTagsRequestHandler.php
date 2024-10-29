<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\TagMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetTagsByIdUseCase;

class GetTagsRequestHandler implements RequestHandler {
	private GetTagsByIdUseCase $get_tags_by_id_use_case;

	public function __construct(
		GetTagsByIdUseCase $get_tags_by_id_use_case
	) {
		$this->get_tags_by_id_use_case = $get_tags_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_TAGS;
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

		Logger::debug( "Sending tags for ids " . json_encode( $ids ) );

		$tags = $this->get_tags_by_id_use_case->invoke( $ids );

		$tag_dtos = array_map(
			function ( Tag $tag ) {
				return TagMapper::to_dto( $tag );
			},
			$tags
		);

		return PluginResponse::plugin_response()->body( $tag_dtos );
	}
}