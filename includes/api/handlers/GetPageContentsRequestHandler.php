<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PageContentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\PageContent;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\Page\GetPageContentsByIdUseCase;

class GetPageContentsRequestHandler implements RequestHandler {
	private GetPageContentsByIdUseCase $get_page_contents_by_id_use_case;

	public function __construct(
		GetPageContentsByIdUseCase $get_page_contents_by_id_use_case
	) {
		$this->get_page_contents_by_id_use_case = $get_page_contents_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_PAGE_CONTENTS;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of pages, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		if ( ! isset( $_GET['ids'] ) ) {
			return PluginResponse::plugin_response()->status( 400 );
		}

		$cleaned_ids = sanitize_text_field( $_GET['ids'] );
		$ids         = array_map(
			function ( $id ) {
				return absint( $id );
			},
			explode( ",", $cleaned_ids )
		);

		$user_id         = $_GET['user_id'] ?? null;
		$cleaned_user_id = null;
		if ( $user_id ) {
			$cleaned_user_id = absint( sanitize_text_field( $user_id ) );
		}

		Logger::debug( "Sending page contents for ids " . json_encode( $ids ) . " for user " . $user_id );

		$page_contents = $this->get_page_contents_by_id_use_case->invoke( $ids, $cleaned_user_id );

		$page_content_dtos = array_map(
			function ( PageContent $page_content ) {
				return PageContentMapper::to_dto( $page_content );
			},
			$page_contents
		);

		return PluginResponse::plugin_response()->body( $page_content_dtos );
	}
}