<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\Post\SavePostSyncBatchSizeUseCase;

class SavePostSyncBatchSizeHandler implements RequestHandler {
    private SavePostSyncBatchSizeUseCase $save_post_sync_batch_size_use_case;


    public function __construct( SavePostSyncBatchSizeUseCase $savePostSyncBatchSizeUseCase ) {
        $this->save_post_sync_batch_size_use_case = $savePostSyncBatchSizeUseCase;
    }

    public function can_handle_request( PluginRequest $request ): bool {
        return $request->get_action() == Endpoints::$SAVE_POST_SYNC_BATCH_SIZE;
    }

    public function handle_request( PluginRequest $request ): PluginResponse {
        Logger::debug( "Found handler for Appful request" );

        $body_input = sanitize_text_field( file_get_contents( 'php://input' ) );
        $data       = json_decode( $body_input, true );

        // required fields
        if ( ! isset( $data["size"] ) ) {
            Logger::error( "Some parameters for setting the batch size are missing!" );

            return PluginResponse::plugin_response()->status( 400 );  // Bad Request
        }

        // sanitize fields
        $size = intval( sanitize_text_field( $data["size"] ) );

        $this->save_post_sync_batch_size_use_case->invoke( $size );

        return PluginResponse::plugin_response();
    }
}
