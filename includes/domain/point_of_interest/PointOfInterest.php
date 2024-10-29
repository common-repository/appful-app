<?php

namespace AppfulPlugin\Domain\PointOfInterest;

use DateTime;

abstract class PointOfInterest {
	private int $id;
	private string $name;
	private float $long;
	private float $lat;
	private DateTime $modified;

	protected function __construct( int $id, string $name, float $long, float $lat, DateTime $modified ) {
		$this->id       = $id;
		$this->name     = $name;
		$this->long     = $long;
		$this->lat      = $lat;
		$this->modified = $modified;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_name(): string {
		return $this->name;
	}

	public function get_long(): float {
		return $this->long;
	}

	public function get_lat(): float {
		return $this->lat;
	}

	public function get_modified(): DateTime {
		return $this->modified;
	}
}
