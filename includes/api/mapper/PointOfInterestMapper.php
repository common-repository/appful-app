<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\PointOfInterest\PointOfInterestDto;
use AppfulPlugin\Api\Dtos\PointOfInterest\PostPointOfInterestDto;
use AppfulPlugin\Domain\PointOfInterest\PointOfInterest;
use AppfulPlugin\Domain\PointOfInterest\PostPointOfInterest;
use AppfulPlugin\Domain\PointOfInterest\WebPointOfInterest;
use AppfulPlugin\Helper\DateParser;
use RuntimeException;

class PointOfInterestMapper {
	public static function to_dto( PointOfInterest $poi ): PointOfInterestDto {
		if ( $poi instanceof PostPointOfInterest ) {
			return new PostPointOfInterestDto(
				$poi->get_id(),
				$poi->get_name(),
				$poi->get_long(),
				$poi->get_lat(),
				DateParser::dateToString($poi->get_modified()),
				$poi->get_post_id()
			);
		}

		throw new RuntimeException( "Illegal type of point of interest!" );
	}
}
