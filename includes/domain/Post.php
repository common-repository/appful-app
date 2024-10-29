<?php

namespace AppfulPlugin\Domain;

use DateTime;

class Post {
	private int $id = - 1;
	private string $title = "";
	private string $url = "";
	private ?User $author = null;
	/** @var Category[] */
	private array $categories = [];
	/** @var Tag[] */
	private array $tags = [];
	private ?Attachment $thumbnail = null;
	/** @var Attachment[] */
	private array $attachments = [];
	private string $status = "";
	private string $language = "";
	private DateTime $modified;
	private DateTime $date;
	private string $comment_status = "";
	private bool $sticky = false;
	private bool $send_push = true;
	/** @var Role[] */
	private array $roles = [];

	public function __construct() {
		$this->modified = new DateTime();
		$this->date     = new DateTime();
	}

	/**
	 * @param Category[] $categories
	 * @param Tag[] $tags
	 * @param Attachment[] $attachments
	 * @param Role[] $roles
	 */
	public static function post(
		int $id = - 1,
		string $title = "",
		string $url = "",
		?User $author = null,
		array $categories = [],
		array $tags = [],
		?Attachment $thumbnail = null,
		array $attachments = [],
		string $status = "",
		string $language = "",
		?DateTime $modified = null,
		?DateTime $date = null,
		string $comment_status = "",
		bool $sticky = false,
		bool $send_push = true,
		array $roles = []
	): Post {
		return ( new Post() )
			->id( $id )
			->title( $title )
			->url( $url )
			->author( $author )
			->categories( $categories )
			->tags( $tags )
			->thumbnail( $thumbnail )
			->attachments( $attachments )
			->status( $status )
			->language( $language )
			->modified( $modified ?? new DateTime() )
			->date( $date ?? new DateTime() )
			->comment_status( $comment_status )
			->sticky( $sticky )
			->send_push( $send_push )
			->roles( $roles );
	}

	public function language( string $language ): Post {
		$this->language = $language;

		return $this;
	}

	public function send_push( bool $send_push ): Post {
		$this->send_push = $send_push;

		return $this;
	}

	public function status( string $status ): Post {
		$this->status = $status;

		return $this;
	}

	public function sticky( bool $sticky ): Post {
		$this->sticky = $sticky;

		return $this;
	}

	/**
	 * @param Attachment[] $attachments
	 */
	public function attachments( array $attachments ): Post {
		$this->attachments = $attachments;

		return $this;
	}

	public function thumbnail( ?Attachment $thumbnail ): Post {
		$this->thumbnail = $thumbnail;

		return $this;
	}

	/**
	 * @param Tag[] $tags
	 */
	public function tags( array $tags ): Post {
		$this->tags = $tags;

		return $this;
	}

	/**
	 * @param Role[] $roles
	 */
	public function roles( array $roles ): Post {
		$this->roles = $roles;

		return $this;
	}

	/**
	 * @param Category[] $categories
	 */
	public function categories( array $categories ): Post {
		$this->categories = $categories;

		return $this;
	}

	public function author( ?User $author ): Post {
		$this->author = $author;

		return $this;
	}

	public function url( string $url ): Post {
		$this->url = $url;

		return $this;
	}

	public function title( string $title ): Post {
		$this->title = $title;

		return $this;
	}

	public function id( int $id ): Post {
		$this->id = $id;

		return $this;
	}

	public function modified( DateTime $modified ): Post {
		$this->modified = $modified;

		return $this;
	}

	public function date( DateTime $date ): Post {
		$this->date = $date;

		return $this;
	}

	public function comment_status( string $comment_status ): Post {
		$this->comment_status = $comment_status;

		return $this;
	}

	/**
	 * @return  Role[]
	 */
	public function get_roles(): array {
		return $this->roles;
	}

	public function get_send_push(): bool {
		return $this->send_push;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_sticky(): bool {
		return $this->sticky;
	}

	public function get_url(): string {
		return $this->url;
	}

	public function get_author(): ?User {
		return $this->author;
	}

	/** @return Category[] */
	public function get_categories(): array {
		return $this->categories;
	}

	/** @return Tag[] */
	public function get_tags(): array {
		return $this->tags;
	}

	public function get_thumbnail(): ?Attachment {
		return $this->thumbnail;
	}

	/** @return Attachment[] */
	public function get_attachments(): array {
		return $this->attachments;
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