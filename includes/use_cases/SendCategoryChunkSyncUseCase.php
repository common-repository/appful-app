<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\SyncChunkMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class SendCategoryChunkSyncUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( SyncChunk $sync_items ) {
		$sync_item_dtos = SyncChunkMapper::to_dto( $sync_items );

		Logger::debug( "Sending category chunk to sync: " . json_encode( $sync_item_dtos ) );
		$request = HttpRequest::backend_request()->method( "PATCH" )->body( $sync_item_dtos )->path( Constants::$TAXONOMY_PATH . "/categories/sync" );
		$this->backend_client->send_request( $request );
	}
}