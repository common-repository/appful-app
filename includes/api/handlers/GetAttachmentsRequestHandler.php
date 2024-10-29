<?php

namespace AppfulPlugin\Api\Handlers;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Mapper\AttachmentMapper;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\GetAttachmentsByIdUseCase;

class GetAttachmentsRequestHandler implements RequestHandler {
	private GetAttachmentsByIdUseCase $get_attachments_by_id_use_case;

	public function __construct(
		GetAttachmentsByIdUseCase $get_attachments_by_id_use_case
	) {
		$this->get_attachments_by_id_use_case = $get_attachments_by_id_use_case;
	}

	public function can_handle_request( PluginRequest $request ): bool {
		return $request->get_action() == Endpoints::$GET_ATTACHMENTS;
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

		Logger::debug( "Sending attachments for ids " . json_encode( $ids ) );

		$attachments = $this->get_attachments_by_id_use_case->invoke( $ids );

		$attachment_dtos = array_map(
			function ( Attachment $attachment ) {
				return AttachmentMapper::to_dto( $attachment );
			},
			$attachments
		);

		return PluginResponse::plugin_response()->body( $attachment_dtos );
	}
}