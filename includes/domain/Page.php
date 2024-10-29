<?php

namespace AppfulPlugin\Domain;

use DateTime;

class Page {
	private int $id = - 1;
	private string $title = "";
	private string $url = "";
	private ?User $author = null;
	private ?Attachment $thumbnail = null;
	private string $status = "";
	private string $language = "";
	private DateTime $modified;
	private DateTime $date;
	private string $comment_status = "";
	/** @var Role[] */
	private array $roles = [];

	public function __construct() {
		$this->modified = new DateTime();
		$this->date     = new DateTime();
	}

	/**
	 * @param Role[] $roles
	 */
	public static function page(
		int $id = - 1,
		string $title = "",
		string $url = "",
		?User $author = null,
		?Attachment $thumbnail = null,
		string $status = "",
		string $language = "",
		?DateTime $modified = null,
		?DateTime $date = null,
		string $comment_status = "",
		array $roles = []
	): Page {
		return ( new Page() )
			->id( $id )
			->title( $title )
			->url( $url )
			->author( $author )
			->thumbnail( $thumbnail )
			->status( $status )
			->language( $language )
			->modified( $modified ?? new DateTime() )
			->date( $date ?? new DateTime() )
			->comment_status( $comment_status )
			->roles( $roles );
	}

	public function language( string $language ): Page {
		$this->language = $language;

		return $this;
	}

	public function status( string $status ): Page {
		$this->status = $status;

		return $this;
	}

	public function thumbnail( ?Attachment $thumbnail ): Page {
		$this->thumbnail = $thumbnail;

		return $this;
	}

	/**
	 * @param Role[] $roles
	 */
	public function roles( array $roles ): Page {
		$this->roles = $roles;

		return $this;
	}

	public function author( ?User $author ): Page {
		$this->author = $author;

		return $this;
	}

	public function url( string $url ): Page {
		$this->url = $url;

		return $this;
	}

	public function title( string $title ): Page {
		$this->title = $title;

		return $this;
	}

	public function id( int $id ): Page {
		$this->id = $id;

		return $this;
	}

	public function modified( DateTime $modified ): Page {
		$this->modified = $modified;

		return $this;
	}

	public function date( DateTime $date ): Page {
		$this->date = $date;

		return $this;
	}

	public function comment_status( string $comment_status ): Page {
		$this->comment_status = $comment_status;

		return $this;
	}

	/**
	 * @return  Role[]
	 */
	public function get_roles(): array {
		return $this->roles;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_url(): string {
		return $this->url;
	}

	public function get_author(): ?User {
		return $this->author;
	}

	public function get_thumbnail(): ?Attachment {
		return $this->thumbnail;
	}

	public function get_status(): string {
		return $this->status;
	}

	public function get_language(): string {
		return $this->language;
	}

	public function get_modified(): ?DateTime {
		return $this->modified;
	}

	public function get_date(): ?DateTime {
		return $this->date;
	}

	public function get_comment_status(): string {
		return $this->comment_status;
	}
}