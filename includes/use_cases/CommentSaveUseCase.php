<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\CommentMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class CommentSaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( Comment $comment ) {
		$comment_dto = CommentMapper::to_dto( $comment );
		Logger::debug( "Sending comment save request with data: " . json_encode( $comment_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $comment_dto )->path( Constants::$COMMENT_PATH );
		$this->backend_client->send_request( $request );
	}
}