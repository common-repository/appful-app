<?php

namespace AppfulPlugin\Api\Dtos\PointOfInterest;

abstract class PointOfInterestDto {
    public int $id;
    public string $name;
    public float $longitude;
    public float $latitude;
    public string $modified;
    public string $type;

    protected function __construct( int $id, string $name, float $long, float $lat, string $modified, string $type ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->longitude = $long;
        $this->latitude  = $lat;
        $this->modified  = $modified;
        $this->type      = $type;
    }
}
