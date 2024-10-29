<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\WPCommentDatabaseManager;

class SyncCommentsUseCase {
	private GetCommentSyncDataUseCase $get_comment_sync_data_use_case;
	private SendCommentChunkSyncUseCase $send_comment_chunk_sync_use_case;

	public function __construct(
		GetCommentSyncDataUseCase $get_comment_sync_data_use_case,
		SendCommentChunkSyncUseCase $send_comment_chunk_sync_use_case
	) {
		$this->get_comment_sync_data_use_case   = $get_comment_sync_data_use_case;
		$this->send_comment_chunk_sync_use_case = $send_comment_chunk_sync_use_case;
	}

	public function invoke() {
		$sync_id    = uniqid();
		$batch_size = WPCommentDatabaseManager::get_count();
		$chunk_size = Constants::$COMMENT_SYNC_CHUNK_SIZE;

		$chunk = 0;
		while ( true ) {
			$comment_sync_items = $this->get_comment_sync_data_use_case->invoke( $chunk * $chunk_size, $chunk_size );

			$this->send_comment_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $comment_sync_items )
			);

			$chunk ++;

			if ( count( $comment_sync_items ) < $chunk_size ) {
				break;
			}
		}
	}
}
