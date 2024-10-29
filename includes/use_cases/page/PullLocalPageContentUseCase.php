<?php

namespace AppfulPlugin\UseCases\Page;

use AppfulPlugin\Api\Client\SelfClient;
use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\PageContent;
use AppfulPlugin\Helper\Logger;

class PullLocalPageContentUseCase {
    private SelfClient $self_client;

    public function __construct( SelfClient $self_client ) {
        $this->self_client = $self_client;
    }

    public function invoke( int $id, ?int $user_id = null ): ?PageContent {
        Logger::debug( "Pulling local page content for id " . $id . " for user " . $user_id );

        $request_params = [];

        $request_params['id'] = $id;
        if ( isset( $_REQUEST['debug'] ) && $_REQUEST['debug'] == "1" ) {
            $request_params['debug'] = "1";
        }
        if ( $user_id ) {
            $request_params['user_id'] = $user_id;
        }

        $request = HttpRequest::backend_request()->method( "GET" )->path( "/" . Endpoints::$GET_PAGE_CONTENT_LOCAL )->params( $request_params );
        $response = $this->self_client->send_request( $request );

        if ( $response->get_status() != 200 ) {
            return null;
        }

        $page_content_dto = $response->get_body();

        if ( $page_content_dto == null ) {
            return null;
        }

        return PageContent::pageContent()
            ->id( absint( $page_content_dto["id"] ) )
            ->content( $page_content_dto["content"] )
            ->head( $page_content_dto["head"] )
            ->footer( $page_content_dto["footer"] )
            ->body_class( $page_content_dto["body_class"] );
    }
}
