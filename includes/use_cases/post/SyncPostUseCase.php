<?php

namespace AppfulPlugin\UseCases\Post;

class SyncPostUseCase {
    private GetPostSyncItemUseCase $get_post_sync_item_use_case;
    private SendPostSyncUseCase $send_post_sync_use_case;

    public function __construct(
        GetPostSyncItemUseCase $get_post_sync_item_use_case,
        SendPostSyncUseCase $send_post_sync_use_case
    ) {
        $this->get_post_sync_item_use_case = $get_post_sync_item_use_case;
        $this->send_post_sync_use_case     = $send_post_sync_use_case;
    }

    public function invoke( int $post_id, bool $force = false ): void {
        $post = $this->get_post_sync_item_use_case->invoke( $post_id );
        $post = $post->force_update( $force );
        $this->send_post_sync_use_case->invoke( $post );
    }
}
