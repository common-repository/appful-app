<?php

namespace AppfulPlugin\UseCases\Post;

use AppfulPlugin\Wp\WPOptionsManager;

class SavePostSyncBatchSizeUseCase {
    public function invoke( int $size ) {
        if ( $size <= 0 ) {
            WPOptionsManager::delete_post_sync_batch_size();

            return;
        }

        WPOptionsManager::save_post_sync_batch_size( $size );
    }
}
