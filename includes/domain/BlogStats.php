<?php

namespace AppfulPlugin\Domain;

class BlogStats {
	private int $attachment_count = 0;
	private int $post_count = 0;
	private int $user_count = 0;
	private int $page_count = 0;
	private int $comment_count = 0;

	private function __construct() {
	}

	public static function init(): BlogStats {
		return new BlogStats();
	}

	public function get_attachment_count(): int {
		return $this->attachment_count;
	}

	public function attachment_count( int $attachment_count ): BlogStats {
		$this->attachment_count = $attachment_count;

		return $this;
	}

	public function get_post_count(): int {
		return $this->post_count;
	}

	public function post_count( int $post_count ): BlogStats {
		$this->post_count = $post_count;

		return $this;
	}

	public function get_user_count(): int {
		return $this->user_count;
	}

	public function user_count( int $user_count ): BlogStats {
		$this->user_count = $user_count;

		return $this;
	}

	public function get_page_count(): int {
		return $this->page_count;
	}

	public function page_count( int $page_count ): BlogStats {
		$this->page_count = $page_count;

		return $this;
	}

	public function get_comment_count(): int {
		return $this->comment_count;
	}

	public function comment_count( int $comment_count ): BlogStats {
		$this->comment_count = $comment_count;

		return $this;
	}
}
