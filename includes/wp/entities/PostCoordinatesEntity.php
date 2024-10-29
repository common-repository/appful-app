<?php

namespace AppfulPlugin\Wp\Entities;

class PostCoordinatesEntity {
	public ?string $name;
    public float $latitude;
	public float $longitude;

    public function __construct(?string $name, float $latitude, float $longitude) {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
