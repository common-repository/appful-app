<?php

namespace AppfulPlugin\Domain;

use DateTime;

class UserRole {
	private string $id = "";
	private string $role_id = "";
	private ?DateTime $expires = null;

	public static function user_role(
		string $id = "",
		string $role_id = "",
		?DateTime $expires = null
	): UserRole {
		return ( new UserRole() )
			->id( $id )
			->role_id( $role_id )
			->expires( $expires );
	}

	public function id( string $id ): UserRole {
		$this->id = $id;

		return $this;
	}

	public function role_id( string $role_id ): UserRole {
		$this->role_id = $role_id;

		return $this;
	}

	public function expires( ?DateTime $expires ): UserRole {
		$this->expires = $expires;

		return $this;
	}

	public function get_id(): string {
		return $this->id;
	}

	public function get_role_id(): string {
		return $this->role_id;
	}

	public function get_expires(): ?DateTime {
		return $this->expires;
	}
}
