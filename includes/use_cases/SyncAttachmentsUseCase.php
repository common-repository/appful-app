<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\WPAttachmentManager;

class SyncAttachmentsUseCase {
	private GetAttachmentSyncDataUseCase $get_attachment_sync_data_use_case;
	private SendAttachmentChunkSyncUseCase $send_attachment_chunk_sync_use_case;

	public function __construct(
		GetAttachmentSyncDataUseCase $get_attachment_sync_data_use_case,
		SendAttachmentChunkSyncUseCase $send_attachment_chunk_sync_use_case
	) {
		$this->get_attachment_sync_data_use_case   = $get_attachment_sync_data_use_case;
		$this->send_attachment_chunk_sync_use_case = $send_attachment_chunk_sync_use_case;
	}

	public function invoke() {
		$sync_id    = uniqid();
		$batch_size = WPAttachmentManager::get_attachment_count();
		$chunk_size = Constants::$ATTACHMENT_SYNC_CHUNK_SIZE;

		$chunk = 0;
		while ( true ) {
			$attachment_sync_items = $this->get_attachment_sync_data_use_case->invoke($chunk * $chunk_size, $chunk_size);

			$this->send_attachment_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $attachment_sync_items )
			);

			$chunk ++;

			if ( count( $attachment_sync_items ) < $chunk_size ) {
				break;
			}
		}
	}
}
