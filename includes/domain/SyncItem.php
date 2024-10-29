<?php

namespace AppfulPlugin\Domain;

use DateTime;

class SyncItem {
	private int $id = - 1;
	private DateTime $modified;
	private bool $force_update = false;

	public function __construct() {
		$this->modified = new DateTime();
	}

	public static function syncItem(
		int $id = - 1,
		?DateTime $modified = null,
		bool $force_update = false
	): SyncItem {
		return ( new SyncItem() )
			->id( $id )
			->modified( $modified ?? new DateTime() )
			->force_update( $force_update );
	}

	public function id( int $id ): SyncItem {
		$this->id = $id;

		return $this;
	}

	public function modified( DateTime $modified ): SyncItem {
		$this->modified = $modified;

		return $this;
	}

	public function force_update( bool $force_update ): SyncItem {
		$this->force_update = $force_update;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_modified(): DateTime {
		return $this->modified;
	}

	public function get_force_update(): bool {
		return $this->force_update;
	}
}