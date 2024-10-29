<?php

namespace AppfulPlugin\Domain;

class Role {
	private string $id = "";
	private string $name = "";

	public static function role(
		string $id = "",
		string $name = ""
	): Role {
		return ( new Role() )
			->id( $id )
			->name( $name );
	}

	public function id( string $id ): Role {
		$this->id = $id;

		return $this;
	}

	public function name( string $name ): Role {
		$this->name = $name;

		return $this;
	}

	public function get_id(): string {
		return $this->id;
	}

	public function get_name(): string {
		return $this->name;
	}
}
