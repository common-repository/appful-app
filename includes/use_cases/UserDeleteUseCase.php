<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class UserDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( string $user_id ) {
		Logger::debug( "Sending user delete request for: " . $user_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$USER_PATH . "/" . $user_id );
		$this->backend_client->send_request( $request );
	}
}
