<?php

namespace AppfulPlugin\PostForm;

use AppfulPlugin\Helper\TemplateLoader;
use AppfulPlugin\Wp\WPPostManager;
use WP_Post;

class PostForm {
    public function load() {
        $this->setup_ui();
        $this->setup_save_hooks();
    }

    private function setup_save_hooks() {
        add_action(
            "save_post",
            function ( int $post_id ) {
                $this->save_post_meta( $post_id );
            },
            10,
            1
        );
    }

    private function setup_ui() {
        add_action(
            "add_meta_boxes",
            function () {
                $this->register_meta_form();
            },
            10,
            0
        );
    }

    private function save_post_meta( int $post_id ) {
        if ( ! isset( $_POST[ self::$POST_META_NONCE ] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST[ self::$POST_META_NONCE ], basename( __FILE__ ) ) ) {
            return;
        }

        if ( ! current_user_can( "edit_post", $post_id ) ) {
            return;
        }

        if ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) {
            return;
        }

        $post_coordinate_long = null;
        $post_coordinate_lat  = null;
        $post_coordinate_name = null;

        if ( isset( $_POST['appful_coordinate_long'] ) ) {
            $post_coordinate_long = $_POST['appful_coordinate_long'];
        }

        if ( isset( $_POST['appful_coordinate_lat'] ) ) {
            $post_coordinate_lat = $_POST['appful_coordinate_lat'];
        }

        if ( !empty($_POST['appful_coordinate_name']) ) {
            $post_coordinate_name = $_POST['appful_coordinate_name'];
        }

        if ( ! $post_coordinate_lat && ! $post_coordinate_long ) {
            WPPostManager::delete_coordinates( $post_id );

            return;
        }

        if ( ! $post_coordinate_lat ) {
            $post_coordinate_lat = "0";
        }

        if ( ! $post_coordinate_long ) {
            $post_coordinate_long = "0";
        }

        WPPostManager::save_coordinates( $post_id, $post_coordinate_name, $post_coordinate_long, $post_coordinate_lat );
    }

    private function register_meta_form() {
        add_meta_box(
            "appful-meta-fields",
            "Appful",
            function ( WP_Post $post ) {
                wp_nonce_field( basename( __FILE__ ), self::$POST_META_NONCE );
                $this->load_post_meta_template(
                    "appful_post_meta_form.html.twig",
                    $this->get_form_options( $post->ID )
                );
            },
            "post",
            "normal",
            "high",
            null
        );
    }

    private function load_post_meta_template( string $template, array $options ) {
        $template_loader = new TemplateLoader();
        echo( $template_loader->load_template(
            $template,
            $options
        ) );
    }

    private function get_form_options( int $post_id = - 1 ): array {
        if ( $post_id != - 1 ) {
            $coordinates = WPPostManager::get_post_coordinates( $post_id );

            if ( $coordinates ) {
                return [
                    "coordinates_name" => $coordinates->name,
                    "coordinates_lat"  => $coordinates->latitude,
                    "coordinates_long" => $coordinates->longitude
                ];
            }
        }

        return [
            "coordinates_name" => "",
            "coordinates_lat"  => "",
            "coordinates_long" => ""
        ];
    }

    private static string $POST_META_NONCE = "appful-post-meta-nonce";
}
