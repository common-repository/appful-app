<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\PostContent;
use AppfulPlugin\Wp\WPPostManager;

class GetLocalPostContentByIdUseCase {
    public function invoke( int $id ): ?PostContent {
        $this->configure_active_filter( true );
        $post_content = WPPostManager::get_post_content_by_id( $id );
        $this->configure_active_filter( false );

        return $post_content;
    }

    private function configure_active_filter( bool $on ): void {
        add_filter(
            "appful_app_is_post_content_call",
            function ( bool $is_active ) use ( $on ) {
                return $on;
            },
            10,
            1
        );
    }
}
