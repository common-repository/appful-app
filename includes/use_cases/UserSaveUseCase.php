<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\UserMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\User;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class UserSaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( User $user ) {
		$user_dto = UserMapper::to_dto( $user );
		Logger::debug( "Sending user save request with data: " . json_encode( $user_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $user_dto )->path( Constants::$USER_PATH );
		$this->backend_client->send_request( $request );
	}
}
