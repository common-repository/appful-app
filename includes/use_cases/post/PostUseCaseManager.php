<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Api\Client\BackendClient;

class PostUseCaseManager {
    private GetTaxonomyPostSyncItemsUseCase $get_taxonomy_post_sync_items_use_case;
    private GetPostSyncItemsUseCase $get_post_sync_data_use_case;
    private GetPostSyncItemUseCase $get_post_sync_item_use_case;

    private SendPostChunkSyncUseCase $send_post_chunk_sync_use_case;
    private SendPostSyncUseCase $send_post_sync_use_case;

    private SyncTaxonomyPostsUseCase $sync_taxonomy_posts_use_case;
    private SyncPostsUseCase $sync_posts_use_case;
    private SyncPostUseCase $sync_post_use_case;

    private GetPostSyncBatchSizeUseCase $get_post_sync_batch_size_use_case;
    private SavePostSyncBatchSizeUseCase $save_post_sync_batch_size_use_case;

    public function __construct( BackendClient $backend_client ) {
        $this->get_post_sync_batch_size_use_case  = new GetPostSyncBatchSizeUseCase();
        $this->save_post_sync_batch_size_use_case = new SavePostSyncBatchSizeUseCase();

        $this->get_post_sync_item_use_case           = new GetPostSyncItemUseCase();
        $this->get_post_sync_data_use_case           = new GetPostSyncItemsUseCase();
        $this->get_taxonomy_post_sync_items_use_case = new GetTaxonomyPostSyncItemsUseCase();

        $this->send_post_chunk_sync_use_case = new SendPostChunkSyncUseCase( $backend_client );
        $this->send_post_sync_use_case       = new SendPostSyncUseCase( $backend_client );

        $this->sync_posts_use_case          = new SyncPostsUseCase( $this->get_post_sync_data_use_case, $this->send_post_chunk_sync_use_case, $this->get_post_sync_batch_size_use_case );
        $this->sync_post_use_case           = new SyncPostUseCase( $this->get_post_sync_item_use_case, $this->send_post_sync_use_case );
        $this->sync_taxonomy_posts_use_case = new SyncTaxonomyPostsUseCase( $this->get_taxonomy_post_sync_items_use_case, $this->send_post_chunk_sync_use_case, $this->get_post_sync_batch_size_use_case );
    }

    public function get_sync_post_use_case(): SyncPostUseCase {
        return $this->sync_post_use_case;
    }

    public function get_sync_posts_use_case(): SyncPostsUseCase {
        return $this->sync_posts_use_case;
    }

    public function get_sync_taxonomy_posts_use_case(): SyncTaxonomyPostsUseCase {
        return $this->sync_taxonomy_posts_use_case;
    }

    public function get_post_sync_batch_size_use_case(): GetPostSyncBatchSizeUseCase {
        return $this->get_post_sync_batch_size_use_case;
    }

    public function get_save_post_sync_batch_size_use_case(): SavePostSyncBatchSizeUseCase {
        return $this->save_post_sync_batch_size_use_case;
    }
}
