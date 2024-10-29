<?php

namespace AppfulPlugin\Api\Dtos;

class BlogSettingsDto {
    public int $post_sync_batch_size;

    public function __construct( int $post_sync_batch_size ) {
        $this->post_sync_batch_size = $post_sync_batch_size;
    }
}
