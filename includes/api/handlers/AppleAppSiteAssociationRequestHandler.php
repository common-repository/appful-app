<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetAppleAppSiteAssociationUseCase;

class AppleAppSiteAssociationRequestHandler implements RequestHandler {
	private GetAppleAppSiteAssociationUseCase $get_apple_app_site_association_use_case;

	public function __construct( GetAppleAppSiteAssociationUseCase $get_apple_app_site_association_use_case ) {
		$this->get_apple_app_site_association_use_case = $get_apple_app_site_association_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$SITE_ASSOCIATION;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );
		$value = $this->get_apple_app_site_association_use_case->invoke();
		if ( $value == null ) {
			return PluginResponse::plugin_response()->status( 404 );
		} else {
			return PluginResponse::plugin_response()->body( $value )->encoded( true );
		}
	}
}