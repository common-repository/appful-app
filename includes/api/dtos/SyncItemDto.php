<?php

namespace AppfulPlugin\Api\Dtos;

class SyncItemDto {
	public int $id = - 1;
	public string $modified = "";
	public bool $force_update = false;

	public function __construct( int $id, string $modified, bool $force_update ) {
		$this->id           = $id;
		$this->modified     = $modified;
		$this->force_update = $force_update;
	}
}
