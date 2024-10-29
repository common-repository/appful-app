<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class AttachmentDeleteUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( string $attachment_id ) {
		Logger::debug( "Sending attachment delete request for: " . $attachment_id );
		$request = HttpRequest::backend_request()->method( "DELETE" )->path( Constants::$ATTACHMENT_PATH . "/" . $attachment_id );
		$this->backend_client->send_request( $request );
	}
}
