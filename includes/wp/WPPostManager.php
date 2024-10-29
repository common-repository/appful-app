<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\PointOfInterest\PointOfInterest;
use AppfulPlugin\Domain\Post;
use AppfulPlugin\Domain\PostContent;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\Wp\Entities\PostCoordinatesEntity;
use AppfulPlugin\Wp\Mapper\PostMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Post;

class WPPostManager {
    public static function get_post_permalink( WP_Post $post ): ?string {
        return get_permalink( $post );
    }

    public static function is_post_sticky( int $post_id ): bool {
        return is_sticky( $post_id );
    }

    public static function should_send_push( int $post_id ): bool {
        $push_term = get_term_by( "slug", Constants::$APPFUL_TAXONOMY_PUSH_TERM_SLUG, Constants::$APPFUL_TAXONOMY_NAME );

        if ( $push_term ) {
            return has_term( $push_term->term_id, Constants::$APPFUL_TAXONOMY_NAME, $post_id ) == false;
        }

        return true;
    }

    public static function get_post_language( int $post_id ): string {
        return LanguageHelper::get_post_language( $post_id );
    }

    public static function get_post_for_id( int $post_id ): ?Post {
        $post = get_post( $post_id );
        if ( $post != null ) {
            return PostMapper::to_domain( $post );
        } else {
            return null;
        }
    }

    public static function get_post_count(): int {
        return WPPostDatabaseManager::get_count_for_type( "post" );
    }

    public static function get_taxonomy_post_count( string $taxonomy, string $term_slug ): int {
        return WPPostDatabaseManager::get_count_for_type_and_taxonomy( "post", $taxonomy, $term_slug );
    }

    /** @return SyncItem[] */
    public static function get_post_sync_items( int $offset, int $count ): array {
        return WPPostDatabaseManager::get_sync_items_for_type( "post", $count, $offset );
    }

    /** @return SyncItem[] */
    public static function get_taxonomy_post_sync_items( string $taxonomy, string $term_slug, int $offset, int $count ): array {
        return WPPostDatabaseManager::get_sync_items_for_type_and_taxonomy( "post", $taxonomy, $term_slug, $count, $offset );
    }

    public static function get_post_sync_item( int $post_id ): SyncItem {
        return WPPostDatabaseManager::get_sync_item_for_type( "post", $post_id );
    }

    public static function get_post_coordinates( int $post_id ): ?PostCoordinatesEntity {
        $meta = get_post_meta( $post_id, Constants::$APPFUL_POST_META_COORDINATES_KEY, true );
        if ( ! $meta ) {
            return null;
        }

        $meta_value = json_decode( $meta );
        if ( $meta_value ) {
            return new PostCoordinatesEntity( $meta_value->name, $meta_value->latitude, $meta_value->longitude );
        }

        return null;
    }

    public static function save_coordinates( int $post_id, ?string $name, string $long, string $lat ) {
        $longitude = floatval( $long );
        $latitude  = floatval( $lat );
        $data = json_encode( new PostCoordinatesEntity( $name, $latitude, $longitude ) );
        update_post_meta( $post_id, Constants::$APPFUL_POST_META_COORDINATES_KEY, $data );
    }

    public static function delete_coordinates( int $post_id ) {
        delete_post_meta( $post_id, Constants::$APPFUL_POST_META_COORDINATES_KEY );
    }

    /**
     * @param int[] $ids
     *
     * @return PointOfInterest[]
     */
    public static function get_points_of_interest_by_id( array $ids ): array {
        return WPPostDatabaseManager::get_points_of_interest_for_ids( $ids );
    }

    /**
     * @param int[] $ids
     *
     * @return Post[]
     */
    public static function get_posts_by_id( array $ids ): array {
        $args = [
            "numberposts" => - 1,
            "include"     => $ids,
            "post_status" => self::get_allowed_post_stati()
        ];

        $all_posts = get_posts( $args );

        $all_posts = array_values(
            array_filter( $all_posts, function ( WP_Post $post ) use ( $ids ) {
                return in_array( $post->ID, $ids );
            } )
        );

        return array_map(
            function ( WP_Post $post ) {
                return PostMapper::to_domain( $post );
            },
            $all_posts
        );
    }

    public static function get_post_content_by_id( int $id ): ?PostContent {
        $args = [
            "post_type"   => "post",
            "p"           => $id,
            "post_status" => self::get_allowed_post_stati()
        ];

        $post_language = self::get_post_language( $id );
        return LanguageHelper::for_language(
            $post_language,
            function() use ( $args ) {
                global $wp_query;

                $wp_query = new \WP_Query( $args );

                self::setup_wp_call();

                if ( have_posts() ) {
                    the_post();

                    Logger::debug( "Getting head!" );
                    $head = self::get_data_code( 'wp_head' );
                    Logger::debug( "Getting content!" );
                    $content = self::get_data_code( 'the_content' );
                    Logger::debug( "Getting footer!" );
                    $footer = self::get_data_code( 'wp_footer' );
                    Logger::debug( "Getting body classes!" );
                    $body_class = self::get_data_code( 'body_class' );

                    wp_reset_postdata();

                    return PostContent::postContent()
                        ->id( get_the_ID() )
                        ->content( $content )
                        ->head( $head )
                        ->footer( $footer )
                        ->body_class( $body_class );
                }

                return null;
            }
        );
    }

    private static function get_data_code( callable $data_callback ): string {
        // The original buffer level before our handling
        $buffer_level_original = ob_get_level();

        // Start our custom buffer which we want to use to get the content
        ob_start();

        // Open some extra buffers in case somehow there is a
        // buffer closed which wasn't opened before
        for ( $i = 0; $i < 100; $i ++ ) {
            ob_start();
        }

        // Amount of buffers with our custom output buffers opened
        $buffer_level_fill = ob_get_level();

        call_user_func( $data_callback );

        // This is the level after the content call, if it is different from the one before
        // we have buffers which weren't closed correctly or were closed too much
        // We can't correctly detect what happened when buffers where closed and
        // opened at the same time, so we just hope that in one call only one of the both happens
        $buffer_level_end = ob_get_level();

        if ( $buffer_level_end > $buffer_level_fill ) {
            Logger::debug( "Buffers where opened too much, getting data with adjustment" );

            // New buffers were opened inside the head
            // We can just proceed by closing the buffers and accumulating their content

            // Get the information how much more buffers we have to close
            $opened_buffer_count = $buffer_level_end - $buffer_level_fill;
            Logger::debug( "Closing " . $opened_buffer_count . " extra buffers to get content" );

            return self::accumulate_buffer_data( $buffer_level_original );
        } else if ( $buffer_level_end < $buffer_level_fill ) {
            Logger::debug( "Buffers where closed too much, getting data with adjustment" );

            // Unknown buffers were closed inside the head
            // We have to reset our buffers and call the function again

            // Even tho there were more buffers closed than opened before, we assume that
            // there are not more than 100 and accumulate all the output
            $output = self::accumulate_buffer_data( $buffer_level_original );

            // Open the correct amount of buffers which are closed in the call
            $closed_buffer_count = $buffer_level_fill - $buffer_level_end;
            Logger::debug( $closed_buffer_count . " extra buffers where closed" );

            return $output;
        } else {
            Logger::debug( "Buffer level normal, getting data without adjustment" );

            // If we don't have a malicious actor in the content call we can use the normal method

            return self::accumulate_buffer_data( $buffer_level_original );
        }
    }

    // Close all buffers until the target level is reached and return the accumulated data
    private static function accumulate_buffer_data( int $target_level ): string {
        $data = "";
        // The first condition is a safety measure in case the target level is negative
        while ( ob_get_level() > 0 && ob_get_level() > $target_level ) {
            $data .= ob_get_clean();
        }

        return $data;
    }

    private static function setup_wp_call() {
        // We try to initialize a "frontend" theme so that all hooks etc.
        // by plugins are setup correctly
        do_action( 'template_redirect' );
    }

    /**
     * @return string[]
     */
    private static function get_allowed_post_stati(): array {
        return array_filter( get_post_stati(), function ( string $status ) {
            return $status != "auto-draft";
        } );
    }
}
