<?php

namespace AppfulPlugin\Api\Handlers\PointOfInterest;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Handlers\RequestHandler;
use AppfulPlugin\Api\Mapper\PointOfInterestMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\PointOfInterest\PointOfInterest;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\PointOfInterest\GetPointsOfInterestByIdUseCase;

class GetPointsOfInterestRequestHandler implements RequestHandler {
    private GetPointsOfInterestByIdUseCase $get_points_of_interest_by_id_use_case;

    public function __construct(
        GetPointsOfInterestByIdUseCase $get_points_of_interest_by_id_use_case
    ) {
        $this->get_points_of_interest_by_id_use_case = $get_points_of_interest_by_id_use_case;
    }

    public function can_handle_request( PluginRequest $request ): bool {
        return $request->get_action() == Endpoints::$GET_POINTS_OF_INTEREST;
    }

    public function handle_request( PluginRequest $request ): PluginResponse {
        Logger::debug( "Found handler for Appful request" );

        // Because there could be a huge amount of POIs, increase the timeout to 10min
        set_time_limit( 60 * 10 );

        if ( ! isset( $_GET['ids'] ) ) {
            return PluginResponse::plugin_response()->status( 400 );
        }

        $cleanedIds = sanitize_text_field( $_GET['ids'] );
        $ids        = array_map(
            function ( $id ) {
                return absint( $id );
            },
            explode( ",", $cleanedIds )
        );

        Logger::debug( "Sending points of interest for ids " . json_encode( $ids ) );

        $points_of_interest = $this->get_points_of_interest_by_id_use_case->invoke( $ids );

        $point_of_interest_dtos = array_map(
            function ( PointOfInterest $point_of_interest ) {
                return PointOfInterestMapper::to_dto( $point_of_interest );
            },
            $points_of_interest
        );

        return PluginResponse::plugin_response()->body( $point_of_interest_dtos );
    }
}
