<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Domain\BlogHooks;
use AppfulPlugin\Domain\BlogInfo;
use AppfulPlugin\Domain\BlogSettings;
use AppfulPlugin\Domain\BlogStats;
use AppfulPlugin\Helper\ClientTokenManager;
use AppfulPlugin\UseCases\Post\GetPostSyncBatchSizeUseCase;
use AppfulPlugin\Wp\Plugins\LanguageHelper;

class WPBlogManager {
    public static function get_blog_info(): BlogInfo {
        return BlogInfo::blog_info()
                       ->hostname( self::get_hostname() )
                       ->site_url( self::get_site_url() )
                       ->languages( self::get_languages() )
                       ->token( ClientTokenManager::getToken() ?? ClientTokenManager::createSession() )
                       ->hooks( self::get_hooks() )
                       ->stats( self::get_stats() )
                       ->settings( self::get_settings() );
    }

    private static function get_hooks(): BlogHooks {
        return BlogHooks::init()
                        ->create_comment( self::get_site_url() . Endpoints::$HOOK . "/" . Endpoints::$CREATE_COMMENT_HOOK )
                        ->authenticate_user( self::get_site_url() . Endpoints::$HOOK . "/" . Endpoints::$AUTHENTICATE_USER_HOOK )
                        ->get_page_content( self::get_site_url() . Endpoints::$HOOK . "/" . Endpoints::$GET_PAGE_CONTENT_HOOK );
    }

    private static function get_stats(): BlogStats {
        return BlogStats::init()
                        ->attachment_count( WPAttachmentManager::get_attachment_count() )
                        ->post_count( WPPostManager::get_post_count() )
                        ->user_count( WPUserManager::get_user_count() )
                        ->page_count( WPPageManager::get_page_count() )
                        ->comment_count( WPCommentManager::get_comment_count() );
    }

    private static function get_settings(): BlogSettings {
        return BlogSettings::init()
                           ->post_sync_batch_size( ( new GetPostSyncBatchSizeUseCase() )->invoke() );
    }

    private static function get_hostname(): string {
        $siteUrl = self::get_site_url();

        return parse_url( $siteUrl, PHP_URL_HOST );
    }

    private static function get_site_url(): string {
        return get_site_url();
    }

    private static function get_languages(): array {
        return LanguageHelper::get_languages();
    }

    public static function get_blog_language(): string {
        return substr( get_bloginfo( "language" ), 0, 2 ) ?? "";
    }
}
