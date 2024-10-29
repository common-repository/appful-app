<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\SelfClient;
use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\PostContent;
use AppfulPlugin\Helper\Logger;

class PullLocalPostContentUseCase {
    private SelfClient $self_client;

    public function __construct( SelfClient $self_client ) {
        $this->self_client = $self_client;
    }

    public function invoke( int $id ): ?PostContent {
        Logger::debug( "Pulling local post content for id: " . $id );

        $request_params = [];

        $request_params['id'] = $id;
        if ( isset( $_REQUEST['debug'] ) && $_REQUEST['debug'] == "1" ) {
            $request_params['debug'] = "1";
        }

        $request = HttpRequest::backend_request()->method( "GET" )->path( "/" . Endpoints::$GET_POST_CONTENT_LOCAL )->params( $request_params );
        $response = $this->self_client->send_request( $request );

        if ( $response->get_status() != 200 ) {
            return null;
        }

        $post_content_dto = $response->get_body();

        if ( $post_content_dto == null ) {
            return null;
        }

        return PostContent::postContent()
            ->id( absint( $post_content_dto["id"] ) )
            ->content( $post_content_dto["content"] )
            ->head( $post_content_dto["head"] )
            ->footer( $post_content_dto["footer"] )
            ->body_class( $post_content_dto["body_class"] );
    }
}
