<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\PageMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\Page;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class PageSaveUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( Page $page ) {
		$page_dto = PageMapper::to_dto( $page );
		Logger::debug( "Sending page save request with data: " . json_encode( $page_dto ) );
		$request = HttpRequest::backend_request()->method( "POST" )->body( $page_dto )->path( Constants::$PAGE_PATH );
		$this->backend_client->send_request( $request );
	}
}
