<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\WPPageManager;

class SyncPagesUseCase {
	private GetPageSyncDataUseCase $get_page_sync_data_use_case;
	private SendPageChunkSyncUseCase $send_page_chunk_sync_use_case;

	public function __construct(
		GetPageSyncDataUseCase $get_page_sync_data_use_case,
		SendPageChunkSyncUseCase $send_page_chunk_sync_use_case
	) {
		$this->get_page_sync_data_use_case   = $get_page_sync_data_use_case;
		$this->send_page_chunk_sync_use_case = $send_page_chunk_sync_use_case;
	}

	public function invoke() {
		$sync_id    = uniqid();
		$batch_size = WPPageManager::get_page_count();
		$chunk_size = Constants::$PAGE_SYNC_CHUNK_SIZE;

		$chunk = 0;
		while ( true ) {
			$page_sync_items = $this->get_page_sync_data_use_case->invoke( $chunk * $chunk_size, $chunk_size );

			$this->send_page_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $page_sync_items )
			);

			$chunk ++;

			if ( count( $page_sync_items ) < $chunk_size ) {
				break;
			}
		}
	}
}
