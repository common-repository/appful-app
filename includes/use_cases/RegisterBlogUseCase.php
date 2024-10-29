<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\BlogInfoMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\Wp\WPBlogManager;
use AppfulPlugin\Wp\WPOptionsManager;

class RegisterBlogUseCase {
    private BackendClient $backend_client;

    public function __construct( BackendClient $backend_client ) {
        $this->backend_client = $backend_client;
    }

    public function invoke(): bool {
        $blog_info     = WPBlogManager::get_blog_info();
        $blog_info_dto = BlogInfoMapper::to_dto( $blog_info );

        Logger::info( "Registering blog with data: " . json_encode( $blog_info_dto ) );

        $request  = HttpRequest::backend_request()->method( "POST" )->body( $blog_info_dto )->path( Constants::$BLOG_PATH );
        $response = $this->backend_client->send_request( $request );
        $body     = $response->get_body();

        if ( $response->get_status() != 200 ) {
            if ( $body != null && isset( $body['error'] ) ) {
                WPOptionsManager::save_last_sync_error( $body['error'] );
            }

            return false;
        }

        if ( $body != null && isset( $body['blog_id'] ) ) {
            WPOptionsManager::save_blog_id( $body['blog_id'] );
        }

        return true;
    }
}
