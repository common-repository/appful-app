<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\BlogInfoMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetBlogInfoUseCase;

class InfoRequestHandler implements RequestHandler {
	private GetBlogInfoUseCase $get_blog_info_use_case;

	public function __construct( GetBlogInfoUseCase $get_blog_info_use_case ) {
		$this->get_blog_info_use_case = $get_blog_info_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$INFO;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		$blog_info     = $this->get_blog_info_use_case->invoke();
		$blog_info_dto = BlogInfoMapper::to_dto( $blog_info );

		return PluginResponse::plugin_response()->body( $blog_info_dto );
	}
}
