<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\WPPostManager;

class SyncPointsOfInterestUseCase {
	private GetPointOfInterestSyncItemsUseCase $get_point_of_interest_sync_items_use_case;
	private SendPointOfInterestChunkSyncUseCase $send_point_of_interest_chunk_sync_use_case;

	public function __construct(
		GetPointOfInterestSyncItemsUseCase $get_point_of_interest_sync_items_use_case,
		SendPointOfInterestChunkSyncUseCase $send_point_of_interest_chunk_sync_use_case
	) {
		$this->get_point_of_interest_sync_items_use_case  = $get_point_of_interest_sync_items_use_case;
		$this->send_point_of_interest_chunk_sync_use_case = $send_point_of_interest_chunk_sync_use_case;
	}

	public function invoke() {
		$sync_id    = uniqid();
		$batch_size = WPPostManager::get_post_count();
		$chunk_size = Constants::$POST_SYNC_CHUNK_SIZE;

		$chunk = 0;
		while ( true ) {
			$point_of_interest_sync_items = $this->get_point_of_interest_sync_items_use_case->invoke( $chunk * $chunk_size, $chunk_size );

			$this->send_point_of_interest_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $point_of_interest_sync_items )
			);

			$chunk ++;

			if ( count( $point_of_interest_sync_items ) < $chunk_size ) {
				break;
			}
		}
	}
}
