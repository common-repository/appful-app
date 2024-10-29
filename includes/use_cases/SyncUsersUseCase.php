<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\WPUserManager;

class SyncUsersUseCase {
	private GetUserSyncDataUseCase $get_user_sync_data_use_case;
	private SendUserChunkSyncUseCase $send_user_chunk_sync_use_case;

	public function __construct(
		GetUserSyncDataUseCase $get_user_sync_data_use_case,
		SendUserChunkSyncUseCase $send_user_chunk_sync_use_case
	) {
		$this->get_user_sync_data_use_case   = $get_user_sync_data_use_case;
		$this->send_user_chunk_sync_use_case = $send_user_chunk_sync_use_case;
	}

	public function invoke() {
		$sync_id    = uniqid();
		$batch_size = WPUserManager::get_user_count();
		$chunk_size = Constants::$USER_SYNC_CHUNK_SIZE;

		$chunk = 0;
		while ( true ) {
			$user_sync_items = $this->get_user_sync_data_use_case->invoke( $chunk * $chunk_size, $chunk_size );

			$this->send_user_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $user_sync_items )
			);

			$chunk ++;

			if ( count( $user_sync_items ) < $chunk_size ) {
				break;
			}
		}
	}
}
