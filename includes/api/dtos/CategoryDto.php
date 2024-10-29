<?php

namespace AppfulPlugin\Api\Dtos;

class CategoryDto {
	public int $id = - 1;
	public string $slug = "";
	public string $title = "";
	public string $description = "";
	public ?CategoryDto $parent = null;
	public string $language = "";
	public ?AttachmentDto $image = null;

	public function __construct( int $id, string $slug, string $title, string $description, ?CategoryDto $parent, string $language, ?AttachmentDto $image ) {
		$this->id          = $id;
		$this->slug        = $slug;
		$this->title       = $title;
		$this->description = $description;
		$this->parent      = $parent;
		$this->language    = $language;
		$this->image       = $image;
	}
}