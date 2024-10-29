<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;
use WP_Post;

class PostHook {
    private UseCaseManager $use_case_manager;

    public function __construct( UseCaseManager $use_case_manager ) {
        $this->use_case_manager = $use_case_manager;
    }

    public function init() {
        add_action(
            "wp_after_insert_post",
            function ( int $post_id, WP_Post $post, bool $update, ?WP_Post $post_before ) {
                $this->after_save_post( $post, $post_before );
            },
            99,
            4
        );

//        add_action(
//            "updated_post_meta",
//            function ( int $meta_id, int $object_id, string $meta_key ) {
//                if ( $meta_key == Constants::$APPFUL_POST_META_COORDINATES_KEY ) {
//                    $this->after_save_post_meta( $object_id );
//                }
//            },
//            10,
//            3
//        );

        add_action(
            "delete_post",
            function ( int $post_id, WP_Post $post ) {
                $this->on_delete_post( $post_id, $post );
            },
            10,
            2
        );

        add_action(
            "delete_post_meta",
            function ( array $meta_ids, int $object_id, string $meta_key ) {
                if ( $meta_key == Constants::$APPFUL_POST_META_COORDINATES_KEY ) {
                    $this->on_delete_post_meta( $object_id );
                }
            },
            10,
            3
        );

        add_action(
            "appful_app_update_post",
            function ( int $post_id ) {
                $this->on_appful_post_update( $post_id );
            },
            10,
            1
        );

        add_action(
            "appful_app_update_taxonomy_posts",
            function ( string $taxonomy, string $term_slug ) {
                $this->on_appful_taxonomy_posts_update( $taxonomy, $term_slug );
            },
            10,
            2
        );
    }

    private function on_delete_post( int $post_id, WP_Post $post ) {
        if ( $post->post_type != "post" ) {
            return;
        }

        Logger::debug( "Post with id " . $post->ID . " deleted!" );

        $this->use_case_manager->post_delete_use_case()->invoke( $post_id );
        $this->use_case_manager->points_of_interest()->get_point_of_interest_delete_use_case()->invoke( $post_id );
    }

    private function on_delete_post_meta( int $post_id ) {
        Logger::debug( "Post-coordinates-meta with id " . $post_id . " deleted!" );

        $this->use_case_manager->points_of_interest()->get_point_of_interest_delete_use_case()->invoke( $post_id );
    }

    private function after_save_post_meta( int $post_id ) {
        Logger::debug( "Post-coordinate-meta with id " . $post_id . " updated!" );

        $this->use_case_manager->points_of_interest()->get_sync_point_of_interest_use_case()->invoke( $post_id );
    }

    private function after_save_post( WP_Post $post, ?WP_Post $post_before ) {
        if ( (defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE) || (defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
            return;
        }

        if ( wp_is_post_revision( $post->ID ) || wp_is_post_autosave( $post->ID ) ) {
            return;
        }

        if ( $post->post_type != "post" ) {
            return;
        }

        if ( $post->post_status == "auto-draft" || $post->post_status == "inherit" ) {
            return;
        }

        Logger::debug( "Post with id " . $post->ID . " inserted with status " . $post->post_status . "!" );

        $old_post_status = "";
        if ( $post_before ) {
            $old_post_status = $post_before->post_status;
        }

        $this->use_case_manager->posts()->get_sync_post_use_case()->invoke( $post->ID, $post->post_status != $old_post_status );
        $this->after_save_post_meta( $post->ID );
    }

    private function on_appful_post_update( int $post_id ) {
        Logger::debug( "Manual appful post update for id " . $post_id );

        $this->use_case_manager->posts()->get_sync_post_use_case()->invoke( $post_id, true );
        $this->use_case_manager->points_of_interest()->get_sync_point_of_interest_use_case()->invoke( $post_id, true );
    }

    private function on_appful_taxonomy_posts_update( string $taxonomy, string $term_slug ) {
        Logger::debug( "Manual appful taxonomy posts update for taxonomy " . $taxonomy . " and term " . $term_slug );

        $this->use_case_manager->posts()->get_sync_taxonomy_posts_use_case()->invoke( $taxonomy, $term_slug );
    }
}
