<?php

namespace AppfulPlugin\Api\Dtos\PointOfInterest;

class PostPointOfInterestDto extends PointOfInterestDto {
	public int $post_id;

	public function __construct( int $id, string $name, float $long, float $lat, string $modified, int $post_id ) {
		parent::__construct( $id, $name, $long, $lat, $modified, "POST" );
		$this->post_id = $post_id;
	}
}
