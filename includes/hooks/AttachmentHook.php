<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\Mapper\AttachmentMapper;

class AttachmentHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"delete_attachment",
			function ( int $attachment_id ) {
				$this->on_delete_attachment( $attachment_id );
			},
			10,
			1,
		);

		add_action(
			"edit_attachment",
			function ( int $attachment_id ) {
				$this->on_save_attachment( $attachment_id );
			},
			10,
			1,
		);

		add_action(
			"add_attachment",
			function ( int $attachment_id ) {
				$this->on_save_attachment( $attachment_id );
			},
			10,
			1,
		);
	}

	private function on_save_attachment( int $attachment_id ) {
		Logger::debug( "Attachment with id " . $attachment_id . " saved!" );

		$attachment_post = get_post( $attachment_id );
		if ( $attachment_post ) {
			$attachment = AttachmentMapper::to_domain( $attachment_post );
			$this->use_case_manager->attachment_save_use_case()->invoke( $attachment );
		}
	}

	private function on_delete_attachment( int $attachment_id ) {
		Logger::debug( "Attachment with id " . $attachment_id . " deleted!" );

		$this->use_case_manager->attachment_delete_use_case()->invoke( $attachment_id );
	}

}