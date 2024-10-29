<?php

namespace AppfulPlugin\Api\Dtos\App;

class AppAdBannerDto {
	public string $image_url = "";
	public string $target_link = "";

	public function __construct( string $image_url, string $target_link ) {
		$this->image_url   = $image_url;
		$this->target_link = $target_link;
	}
}
