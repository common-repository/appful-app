<?php

namespace AppfulPlugin\UseCases\AppSettings;

use AppfulPlugin\Api\Client\BackendClient;

class AppSettingsUseCaseManager {
	private UpdateAppAdBannerUseCase $update_app_ad_banner_use_case;

	public function __construct( BackendClient $backend_client ) {
		$this->update_app_ad_banner_use_case = new UpdateAppAdBannerUseCase( $backend_client );
	}

	public function get_update_app_ad_banner_use_case(): UpdateAppAdBannerUseCase {
		return $this->update_app_ad_banner_use_case;
	}
}
