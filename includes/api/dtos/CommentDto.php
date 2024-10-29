<?php

namespace AppfulPlugin\Api\Dtos;

class CommentDto {
	public int $id = - 1;
	public ?PostDto $post = null;
	public string $author_name = "";
	public string $author_mail = "";
	public string $date = "";
	public string $content = "";
	public string $status = "";
	public ?CommentDto $parent = null;

	public function __construct( int $id, ?PostDto $post, string $author_name, string $author_mail, string $date, string $content, string $status, ?CommentDto $parent ) {
		$this->id          = $id;
		$this->post        = $post;
		$this->author_name = $author_name;
		$this->author_mail = $author_mail;
		$this->date        = $date;
		$this->content     = $content;
		$this->status    = $status;
		$this->parent      = $parent;
	}
}