<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class CommentDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( string $comment_id ) {
		Logger::debug( "Sending comment delete request for: " . $comment_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$COMMENT_PATH . "/" . $comment_id );
		$this->backend_client->send_request( $request );
	}
}