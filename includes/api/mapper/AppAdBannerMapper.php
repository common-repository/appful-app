<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\App\AppAdBannerDto;
use AppfulPlugin\Domain\App\AppAdBanner;

class AppAdBannerMapper {
	public static function to_dto( AppAdBanner $banner ): AppAdBannerDto {
		return new AppAdBannerDto(
			$banner->get_image_url(),
			$banner->get_target_link()
		);
	}
}
