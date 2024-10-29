<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PageMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Page;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetPagesByIdUseCase;

class GetPagesRequestHandler implements RequestHandler {
	private GetPagesByIdUseCase $get_pages_by_id_use_case;

	public function __construct(
		GetPagesByIdUseCase $get_pages_by_id_use_case
	) {
		$this->get_pages_by_id_use_case = $get_pages_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_PAGES;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of pages, increase the timeout to 10min
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

		Logger::debug( "Sending pages for ids " . json_encode( $ids ) );

		$pages = $this->get_pages_by_id_use_case->invoke( $ids );

		$page_dtos = array_map(
			function ( Page $page ) {
				return PageMapper::to_dto( $page );
			},
			$pages
		);

		return PluginResponse::plugin_response()->body( $page_dtos );
	}
}
