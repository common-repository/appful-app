<?php

namespace AppfulPlugin\Api\Dtos;

class BlogStatsDto {
	public int $attachment_count = 0;
	public int $post_count = 0;
	public int $user_count = 0;
	public int $page_count = 0;
	public int $comment_count = 0;

	public function __construct(
		int $attachment_count,
		int $post_count,
		int $user_count,
		int $page_count,
		int $comment_count
	) {
		$this->attachment_count = $attachment_count;
		$this->post_count       = $post_count;
		$this->user_count       = $user_count;
		$this->page_count       = $page_count;
		$this->comment_count    = $comment_count;
	}
}
