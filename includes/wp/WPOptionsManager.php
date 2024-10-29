<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Helper\Constants;

class WPOptionsManager {
    private static function save_option( string $key, ?string $value ): bool {
        if ( $value == null ) {
            return delete_option( $key );
        }

        $current_value = get_option( $key, null );
        if ( $current_value != null ) {
            return update_option( $key, $value );
        } else {
            return add_option( $key, $value );
        }
    }

    private static function get_option( string $key, $default = null ) {
        return get_option( $key, $default );
    }

    public static function save_app_site_association( string $value ) {
        self::save_option( Constants::$APPFUL_APPLE_APP_SITE_ASSOCIATION, $value );
    }

    public static function get_apple_app_site_association(): ?string {
        return self::get_option( Constants::$APPFUL_APPLE_APP_SITE_ASSOCIATION );
    }

    public static function delete_app_site_association(): void {
        self::save_option( Constants::$APPFUL_APPLE_APP_SITE_ASSOCIATION, null );
    }

    public static function save_asset_link( string $value ) {
        self::save_option( Constants::$APPFUL_ANDROID_ASSET_LINK, $value );
    }

    public static function get_android_asset_link(): ?string {
        return self::get_option( Constants::$APPFUL_ANDROID_ASSET_LINK );
    }

    public static function delete_asset_link(): void {
        self::save_option( Constants::$APPFUL_ANDROID_ASSET_LINK, null );
    }

    public static function save_session_id( string $session_id ): void {
        self::save_option( Constants::$APPFUL_SESSION_ID_KEY, $session_id );
    }

    public static function get_session_id(): ?string {
        return self::get_option( Constants::$APPFUL_SESSION_ID_KEY );
    }

    public static function delete_session_id(): void {
        self::save_option( Constants::$APPFUL_SESSION_ID_KEY, null );
    }

    public static function save_username( string $username ): void {
        self::save_option( Constants::$APPFUL_USERNAME_KEY, $username );
    }

    public static function get_username(): ?string {
        return self::get_option( Constants::$APPFUL_USERNAME_KEY );
    }

    public static function delete_username(): void {
        self::save_option( Constants::$APPFUL_USERNAME_KEY, null );
    }

    public static function save_blog_id( string $blog_id ): void {
        self::save_option( Constants::$APPFUL_BLOG_ID_KEY, $blog_id );
    }

    public static function get_blog_id(): ?string {
        return self::get_option( Constants::$APPFUL_BLOG_ID_KEY );
    }

    public static function delete_blog_id(): void {
        self::save_option( Constants::$APPFUL_BLOG_ID_KEY, null );
    }

    public static function save_client_token( string $client_session ): void {
        self::save_option( Constants::$APPFUL_CLIENT_SESSION_KEY, $client_session );
    }

    public static function get_client_token(): ?string {
        return self::get_option( Constants::$APPFUL_CLIENT_SESSION_KEY );
    }

    public static function delete_client_token(): void {
        self::save_option( Constants::$APPFUL_CLIENT_SESSION_KEY, null );
    }

    public static function save_last_sync_error( string $error ): void {
        self::save_option( Constants::$APPFUL_LAST_ERROR_KEY, $error );
    }

    public static function get_last_sync_error(): ?string {
        return self::get_option( Constants::$APPFUL_LAST_ERROR_KEY );
    }

    public static function delete_last_sync_error(): void {
        self::save_option( Constants::$APPFUL_LAST_ERROR_KEY, null );
    }

    public static function save_post_sync_batch_size( int $size ): void {
        self::save_option( Constants::$APPFUL_POST_SYNC_BATCH_SIZE_KEY, $size );
    }

    public static function get_post_sync_batch_size(): ?int {
        return self::get_option( Constants::$APPFUL_POST_SYNC_BATCH_SIZE_KEY );
    }

    public static function delete_post_sync_batch_size(): void {
        self::save_option( Constants::$APPFUL_POST_SYNC_BATCH_SIZE_KEY, null );
    }

    public static function clean() {
        self::delete_session_id();
        self::delete_blog_id();
        self::delete_username();
        self::delete_app_site_association();
        self::delete_asset_link();
        self::delete_client_token();
        self::delete_post_sync_batch_size();
    }
}
