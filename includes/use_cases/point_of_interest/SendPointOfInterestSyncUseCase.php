<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\SyncItemMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class SendPointOfInterestSyncUseCase {
    private BackendClient $backend_client;

    public function __construct( BackendClient $backend_client ) {
        $this->backend_client = $backend_client;
    }

    public function invoke( SyncItem $point_of_interest ) {
        $point_of_interest_dto = SyncItemMapper::to_dto( $point_of_interest );

        Logger::debug( "Sending point of interest save request with data: " . json_encode( $point_of_interest_dto ) );

        $request = HttpRequest::backend_request()->method( "POST" )->body( $point_of_interest_dto )->path( Constants::$POINT_OF_INTEREST_PATH );
        $this->backend_client->send_request( $request );
    }
}
