<?php

namespace AppfulPlugin\Api\Handlers\Page;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Handlers\RequestHandler;
use AppfulPlugin\Api\Mapper\PageContentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\Page\PullLocalPageContentUseCase;

class GetPageContentRequestHandler implements RequestHandler {
    private PullLocalPageContentUseCase $pull_local_page_content_use_case;

    public function __construct(
        PullLocalPageContentUseCase $pull_local_page_content_use_case
    ) {
        $this->pull_local_page_content_use_case = $pull_local_page_content_use_case;
    }

    public function can_handle_request( PluginRequest $request ): bool {
        return $request->get_action() == Endpoints::$GET_PAGE_CONTENT_HOOK;
    }

    public function handle_request( PluginRequest $request ): PluginResponse {
        Logger::debug( "Found handler for Appful request" );

        if ( !isset( $_GET['id'] ) ) {
            return PluginResponse::plugin_response()->status( 400 );
        }

        $cleaned_id = absint( sanitize_text_field( $_GET['id'] ) );

        $request_user_id = $_GET['user_id'] ?? null;
        $cleaned_user_id = null;
        if ( $request_user_id ) {
            $cleaned_user_id = absint( sanitize_text_field( $request_user_id ) );
        }

        Logger::debug( "Sending page content for id " . json_encode( $cleaned_id ) . " for user " . $request_user_id );

        $page_content = $this->pull_local_page_content_use_case->invoke( $cleaned_id, $cleaned_user_id );
        if ( $page_content != null ) {
            return PluginResponse::plugin_response()->body( PageContentMapper::to_dto( $page_content ) );
        } else {
            return PluginResponse::plugin_response()->status( 404 );
        }
    }
}
