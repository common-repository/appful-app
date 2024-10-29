<?php

namespace AppfulPlugin\UseCases\AppSettings;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Mapper\AppAdBannerMapper;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Domain\App\AppAdBanner;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;

class UpdateAppAdBannerUseCase {
	private BackendClient $backend_client;

	public function __construct( BackendClient $backend_client ) {
		$this->backend_client = $backend_client;
	}

	public function invoke( AppAdBanner $ad_banner ) {
		$dto = AppAdBannerMapper::to_dto( $ad_banner );

		Logger::debug( "Update ad banner: " . json_encode( $dto ) );

		$request = HttpRequest::backend_request()->method( "PUT" )->body( $dto )->path( Constants::$APP_SETTINGS_PATH . "/ad-banner" );
		$this->backend_client->send_request( $request, false );
	}
}
