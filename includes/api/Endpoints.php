<?php

namespace AppfulPlugin\Api;

class Endpoints {
    public static string $INFO = "info";
    public static string $LOGS = "logs";

    public static string $SAVE_POST_SYNC_BATCH_SIZE = "save-post-sync-batch-size";

    public static string $CLEAR_LOGS = "clear-logs";

    public static string $SYNC = "sync";
    public static string $SYNC_POSTS = "sync-post";
    public static string $SYNC_POINTS_OF_INTEREST = "sync-points-of-interest";
    public static string $SYNC_PAGES = "sync-page";
    public static string $SYNC_COMMENTS = "sync-comment";
    public static string $SYNC_TAGS = "sync-tag";
    public static string $SYNC_ROLES = "sync-role";
    public static string $SYNC_USERS = "sync-user";
    public static string $SYNC_ATTACHMENTS = "sync-attachment";
    public static string $SYNC_CATEGORIES = "sync-category";

    public static string $GET_ATTACHMENTS = "get-attachment";
    public static string $GET_COMMENTS = "get-comment";
    public static string $GET_CATEGORIES = "get-category";
    public static string $GET_POSTS = "get-post";
    public static string $GET_POINTS_OF_INTEREST = "get-point-of-interest";
    public static string $GET_PAGES = "get-page";
    public static string $GET_POST_CONTENTS = "get-post-content";
    public static string $GET_PAGE_CONTENTS = "get-page-content";
    public static string $GET_POST_CONTENT_LOCAL = "get-post-content-local";
    public static string $GET_PAGE_CONTENT_LOCAL = "get-page-content-local";
    public static string $GET_USERS = "get-user";
    public static string $GET_TAGS = "get-tag";
    public static string $GET_ROLES = "get-role";

    public static string $ASSET_LINKS = "android-asset-links";
    public static string $SITE_ASSOCIATION = "apple-app-site-association";


    public static string $HOOK = "/appful/api";
    public static string $CREATE_COMMENT_HOOK = "create-comment";
    public static string $AUTHENTICATE_USER_HOOK = "authenticate-user";
    public static string $GET_PAGE_CONTENT_HOOK = "get-page-content-hook";
}
