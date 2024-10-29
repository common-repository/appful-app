<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\CategoryMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\Category;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class CategorySaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( Category $category ) {
		$category_dto = CategoryMapper::to_dto( $category );
		Logger::debug( "Sending category save request with data: " . json_encode( $category_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $category_dto )->path( Constants::$TAXONOMY_PATH . "/categories" );
		$this->backend_client->send_request( $request );
	}
}