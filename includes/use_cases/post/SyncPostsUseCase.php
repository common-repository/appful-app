<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Wp\WPPostManager;

class SyncPostsUseCase {
    private GetPostSyncItemsUseCase $get_post_sync_data_use_case;
    private SendPostChunkSyncUseCase $send_post_chunk_sync_use_case;
    private GetPostSyncBatchSizeUseCase $get_post_sync_batch_size_use_case;

    public function __construct(
        GetPostSyncItemsUseCase $get_post_sync_data_use_case,
        SendPostChunkSyncUseCase $send_post_chunk_sync_use_case,
        GetPostSyncBatchSizeUseCase $get_post_sync_batch_size_use_case
    ) {
        $this->get_post_sync_data_use_case       = $get_post_sync_data_use_case;
        $this->send_post_chunk_sync_use_case     = $send_post_chunk_sync_use_case;
        $this->get_post_sync_batch_size_use_case = $get_post_sync_batch_size_use_case;
    }

    public function invoke() {
        $sync_id    = uniqid();
        $batch_size = WPPostManager::get_post_count();
        $chunk_size = $this->get_post_sync_batch_size_use_case->invoke();

        $chunk = 0;
        while ( true ) {
            $post_sync_items = $this->get_post_sync_data_use_case->invoke( $chunk * $chunk_size, $chunk_size );

            $this->send_post_chunk_sync_use_case->invoke(
                SyncChunk::syncChunk()
                         ->batch_id( $sync_id )
                         ->chunk_size( $chunk_size )
                         ->batch_size( $batch_size )
                         ->chunk_items( $post_sync_items )
            );

            $chunk ++;

            if ( count( $post_sync_items ) < $chunk_size ) {
                break;
            }
        }
    }
}
