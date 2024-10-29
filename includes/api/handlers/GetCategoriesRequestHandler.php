<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\CategoryMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Category;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetCategoriesByIdUseCase;

class GetCategoriesRequestHandler implements RequestHandler {
	private GetCategoriesByIdUseCase $get_categories_by_id_use_case;

	public function __construct( GetCategoriesByIdUseCase $get_categories_by_id_use_case ) {
		$this->get_categories_by_id_use_case = $get_categories_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_CATEGORIES;
	}

	public function handle_request( PluginRequest $request ): PluginResponse {
		Logger::debug( "Found handler for Appful request" );

		// Because there could be a huge amount of posts, increase the timeout to 10min
		set_time_limit( 60 * 10 );

		if ( ! isset( $_GET['ids'] ) ) {
			return PluginResponse::plugin_response()->status( 400 );
		}

		$cleanedIds = sanitize_text_field( $_GET['ids'] );
		$ids        = array_map(
			function ( $id ) {
				return absint( $id );
			},
			explode( ",", $cleanedIds )
		);

		Logger::debug( "Sending categories for ids " . json_encode( $ids ) );

		$categories = $this->get_categories_by_id_use_case->invoke( $ids );

		$category_dtos = array_map(
			function ( Category $category ) {
				return CategoryMapper::to_dto( $category );
			},
			$categories
		);

		return PluginResponse::plugin_response()->body( $category_dtos );
	}
}
