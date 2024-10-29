<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Wp\WPOptionsManager;

class GetPostSyncBatchSizeUseCase {
    public function invoke(): int {
        $saved_sync_size = WPOptionsManager::get_post_sync_batch_size();
        if ( ! $saved_sync_size ) {
            return Constants::$POST_SYNC_CHUNK_SIZE;
        }

        return $saved_sync_size;
    }
}
