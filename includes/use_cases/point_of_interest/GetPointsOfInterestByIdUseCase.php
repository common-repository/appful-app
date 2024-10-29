<?php

namespace AppfulPlugin\UseCases\PointOfInterest;

use AppfulPlugin\Domain\PointOfInterest\PointOfInterest;
use AppfulPlugin\Wp\WPPostManager;

class GetPointsOfInterestByIdUseCase {
	/**
	 * @param int[] $ids
	 *
	 * @return PointOfInterest[]
	 */
	public function invoke( array $ids ): array {
		return WPPostManager::get_points_of_interest_by_id( $ids );
	}
}
