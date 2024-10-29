<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class PageDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( int $page_id ) {
		Logger::debug( "Sending page delete request for: " . $page_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$PAGE_PATH . "/" . $page_id );
		$this->backend_client->send_request( $request );
	}
}
