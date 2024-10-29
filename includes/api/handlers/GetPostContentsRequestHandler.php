<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\PostContentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\PostContent;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetPostContentsByIdUseCase;

class GetPostContentsRequestHandler implements RequestHandler {
    private GetPostContentsByIdUseCase $get_post_contents_by_id_use_case;

    public function __construct(
        GetPostContentsByIdUseCase $get_post_contents_by_id_use_case
    ) {
        $this->get_post_contents_by_id_use_case = $get_post_contents_by_id_use_case;
    }

    public function can_handle_request( PluginRequest $request ): bool {
        return $request->get_action() == Endpoints::$GET_POST_CONTENTS;
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

        Logger::debug( "Sending post contents for ids " . json_encode( $ids ) );

        $postContents = $this->get_post_contents_by_id_use_case->invoke( $ids );

        $post_content_dtos = array_map(
            function ( PostContent $post_content ) {
                return PostContentMapper::to_dto( $post_content );
            },
            $postContents
        );

        return PluginResponse::plugin_response()->body( $post_content_dtos );
    }
}