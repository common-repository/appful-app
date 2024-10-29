<?php

namespace AppfulPlugin\Api\Dtos;

class AttachmentDto {
	public int $id = - 1;
	public string $title = "";
	public string $url = "";
	public int $width = - 1;
	public int $height = - 1;
	public string $size = "";
	public string $language = "";
	public string $modified = "";
	public string $date = "";

	public function __construct( int $id, string $title, string $url, int $width, int $height, string $size, string $language, string $modified, string $date ) {
		$this->id       = $id;
		$this->title    = $title;
		$this->url      = $url;
		$this->width    = $width;
		$this->height   = $height;
		$this->size     = $size;
		$this->language = $language;
		$this->modified = $modified;
		$this->date     = $date;
	}
}