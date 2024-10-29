<?php

namespace AppfulPlugin\Domain;

use DateTime;

class Comment {
	private int $id = - 1;
	private ?Post $post = null;
	private string $author_name = "";
	private string $author_mail = "";
	private DateTime $date;
	private string $content = "";
	private string $status = "";
	private ?Comment $parent = null;

	public function __construct() {
		$this->date = new DateTime();
	}

	public static function comment(
		int $id = - 1,
		?Post $post = null,
		string $author_name = "",
		string $author_mail = "",
		?DateTime $date = null,
		string $content = "",
		string $approved = "",
		?Comment $parent = null
	): Comment {
		return ( new Comment() )
			->id( $id )
			->post( $post )
			->author_name( $author_name )
			->author_mail( $author_mail )
			->date( $date ?? new DateTime() )
			->content( $content )
			->status( $approved )
			->parent( $parent );
	}

	public function author_name( string $author_name ): Comment {
		$this->author_name = $author_name;

		return $this;
	}

	public function post( ?Post $post ): Comment {
		$this->post = $post;

		return $this;
	}

	public function author_mail( string $author_mail ): Comment {
		$this->author_mail = $author_mail;

		return $this;
	}

	public function date( DateTime $date ): Comment {
		$this->date = $date;

		return $this;
	}

	public function content( string $content ): Comment {
		$this->content = $content;

		return $this;
	}

	public function status( string $status ): Comment {
		$this->status = $status;

		return $this;
	}

	public function parent( ?Comment $parent ): Comment {
		$this->parent = $parent;

		return $this;
	}

	public function id( int $id ): Comment {
		$this->id = $id;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_author_name(): string {
		return $this->author_name;
	}

	public function get_post(): ?Post {
		return $this->post;
	}

	public function get_author_mail(): string {
		return $this->author_mail;
	}

	public function get_date(): DateTime {
		return $this->date;
	}

	public function get_content(): string {
		return $this->content;
	}

	public function get_status(): string {
		return $this->status;
	}

	public function get_parent(): ?Comment {
		return $this->parent;
	}
}