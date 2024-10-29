<?php

namespace AppfulPlugin\Helper;

class Constants {
    public static bool $APPFUL_DEBUG = false;

    public static string $PLUGIN_ROOT_DIR = "/appful-app";
    public static string $PLUGIN_ROOT_FILE = "/appful-app.php";

    public static string $APPFUL_SESSION_ID_KEY = "appful-app_session_id";
    public static string $APPFUL_USERNAME_KEY = "appful-app_username";
    public static string $APPFUL_BLOG_ID_KEY = "appful-app_blog_id";

    public static string $APPFUL_CLIENT_SESSION_KEY = "appful-app_client_token_id";
    public static string $APPFUL_LAST_ERROR_KEY = "appful-app_last_error";
    public static string $APPFUL_APPLE_APP_SITE_ASSOCIATION = "appful-app_apple_app_site_association";
    public static string $APPFUL_ANDROID_ASSET_LINK = "appful-app_android_asset_link";
    public static string $APPFUL_POST_SYNC_BATCH_SIZE_KEY = "appful-app_post_sync_batch_size";

    public static string $APPFUL_TERM_IMAGE_META_KEY = "appful-app_term_image";

    public static string $APPFUL_TAXONOMY_NAME = "appful";
    public static string $APPFUL_TAXONOMY_PUSH_TERM_NAME = "Don't send notification";
    public static string $APPFUL_TAXONOMY_PUSH_TERM_SLUG = "push";

    public static string $APPFUL_POST_META_COORDINATES_KEY = "_appful_post_meta_coordinates";

    public static string $APPFUL_API_URL = "https://api.wordpress.appful.io";

    public static string $BLOG_PATH = "/blogs";
    public static string $APPFUL_USER_PATH = "/appfulUsers";
    public static string $USER_PATH = "/users";
    public static string $POST_PATH = "/posts";
    public static string $APP_SETTINGS_PATH = "/app/settings";
    public static string $PAGE_PATH = "/pages";
    public static string $COMMENT_PATH = "/comments";
    public static string $ATTACHMENT_PATH = "/attachments";
    public static string $TAXONOMY_PATH = "/taxonomies";
    public static string $ROLE_PATH = "/roles";
    public static string $POINT_OF_INTEREST_PATH = "/points-of-interest";

    public static string $API_VERSION_1 = "/v1";

    public static int $POST_SYNC_CHUNK_SIZE = 10;
    public static int $PAGE_SYNC_CHUNK_SIZE = 5;
    public static int $COMMENT_SYNC_CHUNK_SIZE = 15;
    public static int $ATTACHMENT_SYNC_CHUNK_SIZE = 50;
    public static int $USER_SYNC_CHUNK_SIZE = 15;
    public static int $CATEGORY_SYNC_CHUNK_SIZE = 15;
    public static int $TAG_SYNC_CHUNK_SIZE = 15;
    public static int $ROLE_SYNC_CHUNK_SIZE = 15;
}