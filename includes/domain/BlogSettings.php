<?php

namespace AppfulPlugin\Domain;

class BlogSettings {
    private int $post_sync_batch_size = 0;

    private function __construct() {
    }

    public static function init(): BlogSettings {
        return new BlogSettings();
    }

    public function post_sync_batch_size( int $size ): BlogSettings {
        $this->post_sync_batch_size = $size;

        return $this;
    }

    public function get_post_sync_batch_size(): int {
        return $this->post_sync_batch_size;
    }
}
