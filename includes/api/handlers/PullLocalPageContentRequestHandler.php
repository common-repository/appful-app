<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PageContentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\Page\GetLocalPageContentByIdUseCase;

class PullLocalPageContentRequestHandler implements RequestHandler {
	private GetLocalPageContentByIdUseCase $get_local_page_content_by_id_use_case;

	public function __construct(
		GetLocalPageContentByIdUseCase $get_local_page_content_by_id_use_case
	) {
		$this->get_local_page_content_by_id_use_case = $get_local_page_content_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_PAGE_CONTENT_LOCAL;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of pages, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		if ( ! isset( $_GET['id'] ) ) {
			return PluginResponse::plugin_response()->status( 400 );
		}

		$cleaned_id      = absint( sanitize_text_field( $_GET['id'] ) );
		$user_id         = $_GET['user_id'] ?? null;
		$cleaned_user_id = null;
		if ( $user_id ) {
			$cleaned_user_id = absint( sanitize_text_field( $user_id ) );
		}

		Logger::debug( "Sending local page content for id " . $cleaned_id . " for user " . $cleaned_user_id );

		$page_content = $this->get_local_page_content_by_id_use_case->invoke( $cleaned_id, $cleaned_user_id );
		if ( $page_content == null ) {
			return PluginResponse::plugin_response()->status( 404 );
		}

		$page_content_dto = PageContentMapper::to_dto( $page_content );

		return PluginResponse::plugin_response()->body( $page_content_dto );
	}
}
