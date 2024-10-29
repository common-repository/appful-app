<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;

class SyncTagsUseCase {
	private GetTagSyncDataUseCase $get_tag_sync_data_use_case;
	private SendTagChunkSyncUseCase $send_tag_chunk_sync_use_case;

	public function __construct(
		GetTagSyncDataUseCase $get_tag_sync_data_use_case,
		SendTagChunkSyncUseCase $send_tag_chunk_sync_use_case
	) {
		$this->get_tag_sync_data_use_case   = $get_tag_sync_data_use_case;
		$this->send_tag_chunk_sync_use_case = $send_tag_chunk_sync_use_case;
	}

	public function invoke() {
		$tag_sync_items = $this->get_tag_sync_data_use_case->invoke();

		$sync_id    = uniqid();
		$batch_size = count( $tag_sync_items );
		$chunk_size = Constants::$TAG_SYNC_CHUNK_SIZE;

		foreach ( array_chunk( $tag_sync_items, $chunk_size ) as $tag_chunk ) {
			$this->send_tag_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $tag_chunk )
			);
		}
	}
}