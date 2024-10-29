<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class PointOfInterestDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( int $point_of_interest_id ) {
		Logger::debug( "Sending point of interest delete request for: " . $point_of_interest_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$POINT_OF_INTEREST_PATH . "/" . $point_of_interest_id );
		$this->backend_client->send_request( $request );
	}
}
