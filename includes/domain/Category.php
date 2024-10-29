<?php

namespace AppfulPlugin\Domain;

class Category {
	private int $id = - 1;
	private string $slug = "";
	private string $title = "";
	private string $description = "";
	private ?Category $parent = null;
	private string $language = "";
	private ?Attachment $image = null;

	public static function category(
		int $id = - 1,
		string $slug = "",
		string $title = "",
		string $description = "",
		?Category $parent = null,
		string $language = "",
		?Attachment $image = null
	): Category {
		return ( new Category() )
			->id( $id )
			->slug( $slug )
			->title( $title )
			->description( $description )
			->parent( $parent )
			->language( $language )
			->image( $image );
	}

	public function language( string $language ): Category {
		$this->language = $language;

		return $this;
	}

	public function image( ?Attachment $image ): Category {
		$this->image = $image;

		return $this;
	}

	public function parent( ?Category $parent ): Category {
		$this->parent = $parent;

		return $this;
	}

	public function description( string $description ): Category {
		$this->description = $description;

		return $this;
	}

	public function title( string $title ): Category {
		$this->title = $title;

		return $this;
	}

	public function slug( string $slug ): Category {
		$this->slug = $slug;

		return $this;
	}

	public function id( int $id ): Category {
		$this->id = $id;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_slug(): string {
		return $this->slug;
	}

	public function get_image(): ?Attachment {
		return $this->image;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_description(): string {
		return $this->description;
	}

	public function get_parent(): ?Category {
		return $this->parent;
	}

	public function get_language(): string {
		return $this->language;
	}
}