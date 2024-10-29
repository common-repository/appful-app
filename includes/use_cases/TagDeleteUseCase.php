<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class TagDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( int $term_id ) {
		Logger::debug( "Sending tag delete request for: " . $term_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$TAXONOMY_PATH . "/tags/" . $term_id );
		$this->backend_client->send_request( $request );
	}
}