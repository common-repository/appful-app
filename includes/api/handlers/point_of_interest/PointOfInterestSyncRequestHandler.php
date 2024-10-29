<?php

namespace AppfulPlugin\Api\Handlers\PointOfInterest;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\api\handlers\RequestHandler;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\PointOfInterest\SyncPointsOfInterestUseCase;

class PointOfInterestSyncRequestHandler implements RequestHandler {
	private SyncPointsOfInterestUseCase $sync_points_of_interest_use_case;

	public function __construct(
		SyncPointsOfInterestUseCase $sync_points_of_interest_use_case
	) {
		$this->sync_points_of_interest_use_case = $sync_points_of_interest_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$SYNC_POINTS_OF_INTEREST;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of POIs, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		$this->sync_points_of_interest_use_case->invoke();

		return PluginResponse::plugin_response()->status( 200 );
	}
}
