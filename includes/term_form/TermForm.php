<?php

namespace AppfulPlugin\TermForm;

use AppfulPlugin\Helper\AssetLoader;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\TemplateLoader;
use WP_Term;

class TermForm {
	public function load(): void {
		$this->setup_ui();
		$this->setup_save_hooks();
	}

	private function setup_save_hooks() {
		$this->setup_tag_save_hooks();
		$this->setup_category_save_hooks();
	}

	private function setup_tag_save_hooks() {
		add_action(
			"created_post_tag",
			function ( int $term_id ) {
				$this->save_term_image( $term_id );
			},
			10,
			1
		);
		add_action(
			"edited_post_tag",
			function ( int $term_id ) {
				$this->save_term_image( $term_id );
			},
			10,
			1
		);
	}

	private function setup_category_save_hooks() {
		add_action(
			"created_category",
			function ( int $term_id ) {
				$this->save_term_image( $term_id );
			},
			10,
			1
		);
		add_action(
			"edited_category",
			function ( int $term_id ) {
				$this->save_term_image( $term_id );
			},
			10,
			1
		);
	}

	private function setup_ui() {
		$this->setup_tag_ui_hooks();
		$this->setup_category_ui_hooks();
		add_action(
			"admin_enqueue_scripts",
			function () {
				$this->load_term_form_assets();
			},
			10,
			0
		);
	}

	private function setup_category_ui_hooks() {
		add_action(
			"category_add_form_fields",
			function () {
				$this->register_add_term_form( $this->get_term_form_options() );
			},
			10,
			0
		);
		add_action(
			"category_edit_form_fields",
			function ( WP_Term $term ) {
				$image_id = get_term_meta( $term->term_id, Constants::$APPFUL_TERM_IMAGE_META_KEY, true );
				$this->register_edit_term_form( $this->get_term_form_options( $image_id ) );
			},
			10,
			1
		);
	}

	private function setup_tag_ui_hooks() {
		add_action(
			"post_tag_add_form_fields",
			function () {
				$this->register_add_term_form( $this->get_term_form_options() );
			},
			10,
			0
		);
		add_action(
			"post_tag_edit_form_fields",
			function ( WP_Term $term ) {
				$image_id = get_term_meta( $term->term_id, Constants::$APPFUL_TERM_IMAGE_META_KEY, true );
				$this->register_edit_term_form( $this->get_term_form_options( $image_id ) );
			},
			10,
			1
		);
	}

	private function save_term_image( int $term_id ) {
		if ( isset( $_POST["appful_term_image"] ) ) {
			$appful_term_image = absint( sanitize_text_field( $_POST["appful_term_image"] ) );
			if ( empty( $appful_term_image ) ) {
				delete_term_meta(
					$term_id,
					Constants::$APPFUL_TERM_IMAGE_META_KEY
				);
			} else {
				update_term_meta(
					$term_id,
					Constants::$APPFUL_TERM_IMAGE_META_KEY,
					$appful_term_image
				);
			}
		}
	}

	private function get_term_form_options( $image_id = "" ): array {
		if ( $image_id == "" ) {
			return [
				"image_id"  => "",
				"image_url" => ""
			];
		} else {
			return [
				"image_id"  => $image_id,
				"image_url" => esc_url( wp_get_attachment_image_url( $image_id, "medium" ) )
			];
		}
	}

	private function register_edit_term_form( array $options ) {
		$this->register_term_form(
			"appful_edit_term_form.html.twig",
			$options
		);
	}

	private function register_add_term_form( array $options ) {
		$this->register_term_form(
			"appful_add_term_form.html.twig",
			$options
		);
	}

	private function register_term_form( string $template, array $options ) {
		$template_loader = new TemplateLoader();
		echo( $template_loader->load_template(
			$template,
			$options
		) );
	}

	private function load_term_form_assets() {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		wp_register_script( "appful_term_form", AssetLoader::load_script_url( "term_form.js" ) );
		wp_enqueue_script( "appful_term_form" );
	}
}