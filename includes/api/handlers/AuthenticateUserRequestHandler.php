<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\AuthenticateRequest;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\AuthenticateUserUseCase;

class AuthenticateUserRequestHandler implements RequestHandler {
	private AuthenticateUserUseCase $authenticate_user_use_case;

	public function __construct(
		AuthenticateUserUseCase $authenticate_user_use_case
	) {
		$this->authenticate_user_use_case = $authenticate_user_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$AUTHENTICATE_USER_HOOK;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		$body_input = sanitize_text_field( file_get_contents( 'php://input' ) );
		$data       = json_decode( $body_input, true );
		$username   = sanitize_text_field( $data["email"] ?? "" );
		$password   = sanitize_text_field( $data["password"] ?? "" );
		$request    = new AuthenticateRequest( $username, $password );

		$userId = $this->authenticate_user_use_case->invoke( $request );
		if ( $userId == null ) {
			return PluginResponse::plugin_response()->status( 401 );
		}

		return PluginResponse::plugin_response()->body( [ "user_id" => $userId ] );
	}
}