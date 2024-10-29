<?php

namespace AppfulPlugin\Domain;

class Tag {
	private int $id = - 1;
	private string $slug = "";
	private string $title = "";
	private string $description = "";
	private string $language = "";
	private ?Attachment $image = null;

	public static function tag(
		int $id = - 1,
		string $slug = "",
		string $title = "",
		string $description = "",
		string $language = "",
		?Attachment $image = null
	): Tag {
		return ( new Tag() )
			->id( $id )
			->slug( $slug )
			->title( $title )
			->description( $description )
			->language( $language )
			->image( $image );
	}

	public function language( string $language ): Tag {
		$this->language = $language;

		return $this;
	}

	public function image( ?Attachment $image ): Tag {
		$this->image = $image;

		return $this;
	}

	public function description( string $description ): Tag {
		$this->description = $description;

		return $this;
	}

	public function title( string $title ): Tag {
		$this->title = $title;

		return $this;
	}

	public function slug( string $slug ): Tag {
		$this->slug = $slug;

		return $this;
	}

	public function id( int $id ): Tag {
		$this->id = $id;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_image(): ?Attachment {
		return $this->image;
	}

	public function get_slug(): string {
		return $this->slug;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_description(): string {
		return $this->description;
	}

	public function get_language(): string {
		return $this->language;
	}
}