<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\CommentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\CreateCommentRequest;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\CreateCommentUseCase;

class CreateCommentRequestHandler implements RequestHandler {
    private CreateCommentUseCase $create_comment_use_case;

    public function __construct(
        CreateCommentUseCase $create_comment_use_case
    ) {
        $this->create_comment_use_case = $create_comment_use_case;
    }

    public function can_handle_request( PluginRequest $request ): bool {
        return $request->get_action() == Endpoints::$CREATE_COMMENT_HOOK;
    }

    public function handle_request( PluginRequest $request ): PluginResponse {
        Logger::debug( "Found handler for Appful request" );

        $body_input = sanitize_text_field( file_get_contents( 'php://input' ) );
        $data       = json_decode( $body_input, true );

        // required fields
        if ( ! isset( $data["username"], $data["email"], $data["content"], $data["post_id"] ) ) {
            Logger::error( "Some parameters for create comment are missing" );

            return PluginResponse::plugin_response()->status( 400 );  // Bad Request
        }

        // sanitize fields
        $username = sanitize_text_field( $data["username"] );
        $email    = sanitize_text_field( $data["email"] );
        $content  = sanitize_text_field( $data["content"] );
        $post_id  = intval( $data["post_id"] );

        // optional field
        $parent_id = isset( $data["parent_id"] ) ? intval( $data["parent_id"] ) : null;

        $request = new CreateCommentRequest( $username, $email, $content, $post_id, $parent_id );

        $comment = $this->create_comment_use_case->invoke( $request );
        if ( $comment == null ) {
            Logger::error( "Creating comment failed" );

            return PluginResponse::plugin_response()->status( 503 );
        }

        $comment_dto = CommentMapper::to_dto( $comment );

        return PluginResponse::plugin_response()->body( $comment_dto );
    }
}