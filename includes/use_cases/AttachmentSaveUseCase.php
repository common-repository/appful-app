<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\AttachmentMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class AttachmentSaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( Attachment $attachment ) {
		$attachment_dto = AttachmentMapper::to_dto( $attachment );
		Logger::debug( "Sending attachment save request with data: " . json_encode( $attachment_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $attachment_dto )->path( Constants::$ATTACHMENT_PATH );
		$this->backend_client->send_request( $request );
	}
}
