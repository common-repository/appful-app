<?php

namespace AppfulPlugin\Domain;

class PageContent {
	private int $id = - 1;
	private string $head = "";
	private string $footer = "";
	private string $body_class = "";
	private string $content = "";

	public static function pageContent(
		int $id = - 1,
		string $head = "",
		string $footer = "",
		string $content = "",
		string $body_class = ""
	): PageContent {
		return ( new PageContent() )
			->id( $id )
			->head( $head )
			->footer( $footer )
			->content( $content );
	}

	public function id( int $id ): PageContent {
		$this->id = $id;

		return $this;
	}

	public function head( string $head ): PageContent {
		$this->head = $head;

		return $this;
	}

	public function footer( string $footer ): PageContent {
		$this->footer = $footer;

		return $this;
	}

	public function content( string $content ): PageContent {
		$this->content = $content;

		return $this;
	}

	public function body_class( string $body_class ): PageContent {
		$this->body_class = $body_class;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_head(): string {
		return $this->head;
	}

	public function get_footer(): string {
		return $this->footer;
	}

	public function get_content(): string {
		return $this->content;
	}

	public function get_body_class(): string {
		return $this->body_class;
	}
}
