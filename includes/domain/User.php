<?php

namespace AppfulPlugin\Domain;

class User {
	private int $id = - 1;
	private string $firstname = "";
	private string $lastname = "";
	private string $display_name = "";
	private string $avatar = "";
	/** @var UserRole[] */
	private array $roles = [];

	/**
	 * @param UserRole[] $roles
	 */
	public static function user(
		int $id = - 1,
		string $firstname = "",
		string $lastname = "",
		string $avatar = "",
		string $display_name = "",
		array $roles = []
	): User {
		return ( new User() )
			->id( $id )
			->firstname( $firstname )
			->lastname( $lastname )
			->avatar( $avatar )
			->display_name( $display_name )
			->roles( $roles );
	}

	public function display_name( string $display_name ): User {
		$this->display_name = $display_name;

		return $this;
	}

	public function avatar( string $avatar ): User {
		$this->avatar = $avatar;

		return $this;
	}

	public function lastname( string $lastname ): User {
		$this->lastname = $lastname;

		return $this;
	}

	public function firstname( string $firstname ): User {
		$this->firstname = $firstname;

		return $this;
	}

	public function id( int $id ): User {
		$this->id = $id;

		return $this;
	}

	/**
	 * @param UserRole[] $roles
	 */
	public function roles( array $roles ): User {
		$this->roles = $roles;

		return $this;
	}

	public function get_firstname(): string {
		return $this->firstname;
	}

	public function get_lastname(): string {
		return $this->lastname;
	}

	public function get_display_name(): string {
		return $this->display_name;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_avatar(): string {
		return $this->avatar;
	}

	/**
	 * @return  UserRole[]
	 */
	public function get_roles(): array {
		return $this->roles;
	}
}
