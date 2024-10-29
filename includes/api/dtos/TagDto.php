<?php

namespace AppfulPlugin\Api\Dtos;

class TagDto {
	public int $id = - 1;
	public string $slug = "";
	public string $title = "";
	public string $description = "";
	public string $language = "";
	public ?AttachmentDto $image = null;

	public function __construct( int $id, string $slug, string $title, string $description, string $language, ?AttachmentDto $image ) {
		$this->id          = $id;
		$this->slug        = $slug;
		$this->title       = $title;
		$this->description = $description;
		$this->language    = $language;
		$this->image       = $image;
	}
}