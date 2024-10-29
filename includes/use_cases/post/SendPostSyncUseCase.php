<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\SyncItemMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class SendPostSyncUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( SyncItem $post ) {
		$post_dto = SyncItemMapper::to_dto( $post );

		Logger::debug( "Sending post save request with data: " . json_encode( $post_dto ) );

		$request = HttpRequest::backend_request()->method( "POST" )->body( $post_dto )->path( Constants::$POST_PATH );
		$this->backend_client->send_request( $request );
	}
}
