<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\Page;
use AppfulPlugin\Domain\PageContent;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Wp\Mapper\PageMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Post;

class WPPageManager {
    public static function get_page_permalink( WP_Post $page ): ?string {
        return get_permalink( $page );
    }

    public static function get_page_language( int $page_id ): string {
        return LanguageHelper::get_page_language( $page_id );
    }

    public static function get_page_count(): int {
        return WPPostDatabaseManager::get_count_for_type( "page" );
    }

    /** @return SyncItem[] */
    public static function get_page_sync_items( int $offset, int $count ): array {
        return WPPostDatabaseManager::get_sync_items_for_type( "page", $count, $offset );
    }

    /**
     * @param int[] $ids
     *
     * @return Page[]
     */
    public static function get_pages_by_id( array $ids ): array {
        $args = [
            "numberposts" => -1,
            "include" => $ids,
            "post_status" => self::get_allowed_page_stati()
        ];

        $all_pages = LanguageHelper::for_each_language( function () use ( $args ) {
            return get_pages( $args );
        } );

        $all_pages = array_values(
            array_filter( $all_pages, function ( WP_Post $page ) use ( $ids ) {
                return in_array( $page->ID, $ids );
            } )
        );

        return array_map(
            function ( WP_Post $page ) {
                return PageMapper::to_domain( $page );
            },
            $all_pages
        );
    }

    public static function get_page_content_by_id( int $id, ?int $user_id = null ): ?PageContent {
        if ( $user_id ) {
            wp_set_current_user( $user_id );
        }

        $args = [
            "posts_per_page" => 1,
            "post_type" => "page",
            "p" => $id,
            "post_status" => self::get_allowed_page_stati()
        ];

        $page_language = self::get_page_language( $id );
        return LanguageHelper::for_language(
            $page_language,
            function () use ( $args ) {
                global $wp_query;

                do_action( 'template_redirect' );

                $wp_query = new \WP_Query( $args );

                if ( have_posts() ) {
                    the_post();

                    ob_start();
                    wp_head();
                    $head = ob_get_clean();

                    ob_start();
                    the_content();
                    $content = ob_get_clean();

                    ob_start();
                    wp_footer();
                    $footer = ob_get_clean();

                    ob_start();
                    body_class();
                    $body_class = ob_get_clean();

                    wp_reset_postdata();

                    return PageContent::pageContent()
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

    /**
     * @return string[]
     */
    private static function get_allowed_page_stati(): array {
        return array_filter( get_post_stati(), function ( string $status ) {
            return $status != "auto-draft";
        } );
    }
}