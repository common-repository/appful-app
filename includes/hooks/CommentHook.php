<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use AppfulPlugin\Wp\Mapper\CommentMapper;
use WP_Comment;

class CommentHook {
	private UseCaseManager $use_case_manager;

	public function __construct( UseCaseManager $use_case_manager ) {
		$this->use_case_manager = $use_case_manager;
	}

	public function init() {
		add_action(
			"transition_comment_status",
			function ( string $new_status, string $old_status, WP_Comment $comment ) {
				$this->on_comment_transition( $new_status, $old_status, $comment );
			},
			10,
			3,
		);

		add_action(
			"comment_post",
			function ( string $comment_id ) {
				$this->on_new_comment( $comment_id );
			},
			10,
			1,
		);

		add_action(
			"edit_comment",
			function ( string $comment_id ) {
				$this->on_edit_comment( $comment_id );
			},
			10,
			1,
		);

		add_action(
			"delete_comment",
			function ( string $comment_id ) {
				$this->on_delete_comment( $comment_id );
			},
			10,
			1,
		);
	}

	private function on_comment_transition( string $new_status, ?string $old_status, WP_Comment $comment ) {
		Logger::debug( "Comment transitioned from " . ( $old_status == null ? "null" : $old_status ) . " to " . $new_status . ": " . json_encode( $comment ) );
		$domain_comment = CommentMapper::to_domain( $comment );
		$this->use_case_manager->comment_save_use_case()->invoke( $domain_comment );
	}

	private function on_new_comment( string $comment_id ) {
		$new_comment        = get_comment( $comment_id );
		$new_comment_status = wp_get_comment_status( $comment_id );
		$this->on_comment_transition( $new_comment_status, null, $new_comment );
	}

	private function on_edit_comment( string $comment_id ) {
		$edited_comment        = get_comment( $comment_id );
		$edited_comment_status = wp_get_comment_status( $comment_id );
		$this->on_comment_transition( $edited_comment_status, null, $edited_comment );
	}

	private function on_delete_comment( string $comment_id ) {
		Logger::debug( "Comment with id " . $comment_id . " deleted!" );

		$this->use_case_manager->comment_delete_use_case()->invoke( $comment_id );
	}

}