<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

class SyncPointOfInterestUseCase {
    private GetPointOfInterestSyncItemUseCase $get_point_of_interest_sync_item_use_case;
    private SendPointOfInterestSyncUseCase $send_point_of_interest_sync_use_case;

    public function __construct(
        GetPointOfInterestSyncItemUseCase $get_point_of_interest_sync_item_use_case,
        SendPointOfInterestSyncUseCase $send_point_of_interest_sync_use_case
    ) {
        $this->get_point_of_interest_sync_item_use_case = $get_point_of_interest_sync_item_use_case;
        $this->send_point_of_interest_sync_use_case     = $send_point_of_interest_sync_use_case;
    }

    public function invoke( int $poi_id, bool $force = false ): void {
        $point_of_interest = $this->get_point_of_interest_sync_item_use_case->invoke( $poi_id );
        $point_of_interest = $point_of_interest->force_update( $force );
        $this->send_point_of_interest_sync_use_case->invoke( $point_of_interest );
    }
}
