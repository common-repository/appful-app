<?php

namespace AppfulPlugin\Domain\App;

class AppAdBanner {
	private string $image_url = "";
	private string $target_link = "";

	private function __construct() {
	}

	public static function init(): AppAdBanner {
		return new AppAdBanner();
	}

	public function image_url( string $image_url ): AppAdBanner {
		$this->image_url = $image_url;

		return $this;
	}

	public function target_link( string $target_link ): AppAdBanner {
		$this->target_link = $target_link;

		return $this;
	}

	public function get_image_url(): string {
		return $this->image_url;
	}

	public function get_target_link(): string {
		return $this->target_link;
	}
}
