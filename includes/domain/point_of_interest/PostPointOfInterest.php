<?php

namespace AppfulPlugin\Domain\PointOfInterest;

use DateTime;

class PostPointOfInterest extends PointOfInterest {
	private int $post_id;

	public function __construct( int $id, string $name, float $long, float $lat, DateTime $modified, int $post_id ) {
		parent::__construct( $id, $name, $long, $lat, $modified );
		$this->post_id = $post_id;
	}

	public function get_post_id(): int {
		return $this->post_id;
	}
}
