<?php

namespace AppfulPlugin\Domain;

use DateTime;

class Attachment {
	private int $id = - 1;
	private string $title = "";
	private string $url = "";
	private string $size = "";
	private int $width = - 1;
	private int $height = - 1;
	private DateTime $modified;
	private DateTime $date;
	private string $language = "";

	public function __construct() {
		$this->modified = new DateTime();
		$this->date     = new DateTime();
	}

	public static function attachment(
		int $id = - 1,
		string $title = "",
		string $url = "",
		int $width = - 1,
		int $height = - 1,
		string $size = "",
		?DateTime $modified = null,
		?DateTime $date = null,
		string $language = ""
	): Attachment {
		return ( new Attachment() )
			->id( $id )
			->title( $title )
			->url( $url )
			->width( $width )
			->height( $height )
			->size( $size )
			->modified( $modified ?? new DateTime() )
			->date( $date ?? new DateTime() )
			->language( $language );
	}

	public function size( string $size ): Attachment {
		$this->size = $size;

		return $this;
	}

	public function height( int $height ): Attachment {
		$this->height = $height;

		return $this;
	}

	public function width( int $width ): Attachment {
		$this->width = $width;

		return $this;
	}

	public function url( string $url ): Attachment {
		$this->url = $url;

		return $this;
	}

	public function title( string $title ): Attachment {
		$this->title = $title;

		return $this;
	}

	public function language( string $language ): Attachment {
		$this->language = $language;

		return $this;
	}

	public function id( int $id ): Attachment {
		$this->id = $id;

		return $this;
	}

	public function modified( DateTime $modified ): Attachment {
		$this->modified = $modified;

		return $this;
	}

	public function date( DateTime $date ): Attachment {
		$this->date = $date;

		return $this;
	}

	public function get_id(): int {
		return $this->id;
	}

	public function get_title(): string {
		return $this->title;
	}

	public function get_url(): string {
		return $this->url;
	}

	public function get_width(): int {
		return $this->width;
	}

	public function get_height(): int {
		return $this->height;
	}

	public function get_size(): string {
		return $this->size;
	}

	public function get_language(): string {
		return $this->language;
	}

	public function get_modified(): DateTime {
		return $this->modified;
	}

	public function get_date(): DateTime {
		return $this->date;
	}
}