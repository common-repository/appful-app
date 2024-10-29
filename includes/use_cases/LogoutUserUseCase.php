<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class LogoutUserUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke() {
		Logger::info( "Logout user!" );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$APPFUL_USER_PATH . "/logout" );
		$this->backend_client->send_request( $request, false );
	}
}