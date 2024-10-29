<?php

namespace AppfulPlugin\Api;

use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\ClientTokenManager;
use AppfulPlugin\Helper\Logger;

class Api {
    private ReqHandler $api_request_handler;

    public function __construct( ReqHandler $api_request_handler ) {
        $this->api_request_handler = $api_request_handler;
    }

    public function init() {
        add_action(
            "wp",
            function () {
                $this->handle_request();
            },
            10,
        );
    }

    private function handle_request() {
        if ( get_query_var( "appful", 0 ) != 0 ) {
            $action = get_query_var( "appful_action" );
            Logger::debug( "Handling WP Plugin request from Appful, action: " . $action );

            $request = PluginRequest::plugin_request()->action( $action );
            if ( $request->requires_auth() ) {
                $token = $this->parse_token();
                $request = $request->token( $token );
            }
            $response = $this->api_request_handler->handle_request( $request );

            $this->respond( $response );
        }
    }

    private function parse_token(): ?string {
        $token = null;

        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;
        if ( $header != null && 0 === stripos( $header, "Bearer " ) ) {
            $token = sanitize_text_field( substr( $header, strlen( "Bearer " ) ) );
        }

        if ( $token == null ) {
            $this->unauthorized();
        }

        $current_session_id = ClientTokenManager::getToken();
        if ( $current_session_id == null ) {
            $this->notAvailable();
        }
        if ( strcmp( $token, $current_session_id ) != 0 ) {
            $this->unauthorized();
        }

        return $token;
    }

    private function unauthorized() {
        $this->respond( PluginResponse::plugin_response()->status( 401 ) );
    }

    private function respond( PluginResponse $response ) {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        if ( $response->get_encoded() ) {
            header( "Content-Type: application/json" );
        }
        status_header( $response->get_status() );
        exit( $response->get_body() );
    }

    private function notAvailable() {
        $this->respond( PluginResponse::plugin_response()->status( 503 ) );
    }
}
