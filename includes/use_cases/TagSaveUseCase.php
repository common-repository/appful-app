<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\TagMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class TagSaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( Tag $tag ) {
		$tag_dto = TagMapper::to_dto( $tag );
		Logger::debug( "Sending tag save request with data: " . json_encode( $tag_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $tag_dto )->path( Constants::$TAXONOMY_PATH . "/tags" );
		$this->backend_client->send_request( $request );
	}
}