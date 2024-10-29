<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Api\Client\BackendClient;

class PointOfInterestUseCaseManager {
	private GetPointOfInterestSyncItemUseCase $get_point_of_interest_sync_item_use_case;
	private SendPointOfInterestSyncUseCase $send_point_of_interest_sync_use_case;
	private SyncPointOfInterestUseCase $sync_point_of_interest_use_case;
	private GetPointOfInterestSyncItemsUseCase $get_point_of_interest_sync_items_use_case;
	private SendPointOfInterestChunkSyncUseCase $send_point_of_interest_chunk_sync_use_case;
	private SyncPointsOfInterestUseCase $sync_points_of_interest_use_case;
	private GetPointsOfInterestByIdUseCase $get_points_of_interest_by_id_use_case;
	private PointOfInterestDeleteUseCase $point_of_interest_delete_use_case;

	public function __construct( BackendClient $backend_client ) {
		$this->get_point_of_interest_sync_item_use_case   = new GetPointOfInterestSyncItemUseCase();
		$this->send_point_of_interest_sync_use_case       = new SendPointOfInterestSyncUseCase( $backend_client );
		$this->sync_point_of_interest_use_case            = new SyncPointOfInterestUseCase( $this->get_point_of_interest_sync_item_use_case, $this->send_point_of_interest_sync_use_case );
		$this->get_point_of_interest_sync_items_use_case  = new GetPointOfInterestSyncItemsUseCase();
		$this->send_point_of_interest_chunk_sync_use_case = new SendPointOfInterestChunkSyncUseCase( $backend_client );
		$this->sync_points_of_interest_use_case           = new SyncPointsOfInterestUseCase( $this->get_point_of_interest_sync_items_use_case, $this->send_point_of_interest_chunk_sync_use_case );
		$this->get_points_of_interest_by_id_use_case      = new GetPointsOfInterestByIdUseCase();
		$this->point_of_interest_delete_use_case          = new PointOfInterestDeleteUseCase( $backend_client );
	}

	public function get_sync_point_of_interest_use_case(): SyncPointOfInterestUseCase {
		return $this->sync_point_of_interest_use_case;
	}

	public function get_sync_points_of_interest_use_case(): SyncPointsOfInterestUseCase {
		return $this->sync_points_of_interest_use_case;
	}

	public function get_get_points_of_interest_by_id_use_case(): GetPointsOfInterestByIdUseCase {
		return $this->get_points_of_interest_by_id_use_case;
	}

	public function get_point_of_interest_delete_use_case(): PointOfInterestDeleteUseCase {
		return $this->point_of_interest_delete_use_case;
	}
}
