<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;

class SyncCategoriesUseCase {
	private GetCategorySyncDataUseCase $get_category_sync_data_use_case;
	private SendCategoryChunkSyncUseCase $send_category_chunk_sync_use_case;

	public function __construct(
		GetCategorySyncDataUseCase $get_category_sync_data_use_case,
		SendCategoryChunkSyncUseCase $send_category_chunk_sync_use_case
	) {
		$this->get_category_sync_data_use_case   = $get_category_sync_data_use_case;
		$this->send_category_chunk_sync_use_case = $send_category_chunk_sync_use_case;
	}

	public function invoke() {
		$category_sync_items = $this->get_category_sync_data_use_case->invoke();

		$sync_id    = uniqid();
		$batch_size = count( $category_sync_items );
		$chunk_size = Constants::$CATEGORY_SYNC_CHUNK_SIZE;

		foreach ( array_chunk( $category_sync_items, $chunk_size ) as $category_chunk ) {
			$this->send_category_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $category_chunk )
			);
		}
	}
}