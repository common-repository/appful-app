<?php

namespace AppfulPlugin\Api\Dtos;

class PostContentDto {
	public int $id = - 1;
	public string $head = "";
	public string $footer = "";
	public string $content = "";
	public string $body_class = "";

	public function __construct( int $id, string $head, string $footer, string $content, string $body_class ) {
		$this->id         = $id;
		$this->head       = $head;
		$this->footer     = $footer;
		$this->content    = $content;
		$this->body_class = $body_class;
	}
}
