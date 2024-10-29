<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class PostDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( int $post_id ) {
		Logger::debug( "Sending post delete request for: " . $post_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$POST_PATH . "/" . $post_id );
		$this->backend_client->send_request( $request );
	}
}