<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Client\SelfClient;
use AppfulPlugin\UseCases\AppSettings\AppSettingsUseCaseManager;
use AppfulPlugin\UseCases\Page\PageUseCaseManager;
use AppfulPlugin\UseCases\PointOfInterest\PointOfInterestUseCaseManager;
use AppfulPlugin\UseCases\Post\PostUseCaseManager;

class UseCaseManager {
    private GetAndroidAssetLinkUseCase $get_android_asset_link_use_case;
    private GetAppleAppSiteAssociationUseCase $get_apple_app_site_association_use_case;
    private GetLogsUseCase $get_logs_use_case;
    private GetBlogInfoUseCase $get_blog_info_use_case;
    private IsLoggedInUseCase $is_logged_in_use_case;
    private DeleteSessionUseCase $delete_session_use_case;
    private RegisterBlogUseCase $register_blog_use_case;
    private CategorySaveUseCase $category_save_use_case;
    private CategoryDeleteUseCase $category_delete_use_case;
    private TagDeleteUseCase $tag_delete_use_case;
    private TagSaveUseCase $tag_save_use_case;
    private GetPostsByIdUseCase $get_posts_by_id_use_case;
    private GetTagSyncDataUseCase $get_tag_sync_data_use_case;
    private SendTagChunkSyncUseCase $send_tag_chunk_sync_use_case;
    private GetTagsByIdUseCase $get_tags_by_id_use_case;
    private SendCategoryChunkSyncUseCase $send_category_chunk_sync_use_case;
    private GetCategorySyncDataUseCase $get_category_sync_data_use_case;
    private GetCategoriesByIdUseCase $get_categories_by_id_use_case;
    private SendAttachmentChunkSyncUseCase $send_attachment_chunk_sync_use_case;
    private GetAttachmentsByIdUseCase $get_attachments_by_id_use_case;
    private GetAttachmentSyncDataUseCase $get_attachment_sync_data_use_case;
    private GetCommentsByIdUseCase $get_comments_by_id_use_case;
    private SendCommentChunkSyncUseCase $send_comment_chunk_sync_use_case;
    private SyncCommentsUseCase $sync_comments_use_case;
    private CommentSaveUseCase $comment_save_use_case;
    private LogoutUserUseCase $logout_user_use_case;
    private SyncTagsUseCase $sync_tags_use_case;
    private GetCommentSyncDataUseCase $get_comment_sync_data_use_case;
    private SyncCategoriesUseCase $sync_categories_use_case;
    private SyncAttachmentsUseCase $sync_attachments_use_case;
    private SyncAllUseCase $sync_all_use_case;
    private PostDeleteUseCase $post_delete_use_case;
    private CommentDeleteUseCase $comment_delete_use_case;
    private AttachmentDeleteUseCase $attachment_delete_use_case;
    private AttachmentSaveUseCase $attachment_save_use_case;
    private GetUsersByIdUseCase $get_users_by_id_use_case;
    private GetUserSyncDataUseCase $get_user_sync_data_use_case;
    private SendUserChunkSyncUseCase $send_user_chunk_sync_use_case;
    private UserDeleteUseCase $user_delete_use_case;
    private UserSaveUseCase $user_save_use_case;
    private SyncUsersUseCase $sync_users_use_case;
    private GetPostContentsByIdUseCase $get_post_contents_by_id_use_case;
    private ClearLogsUseCase $clear_logs_use_case;
    private AuthenticateUserUseCase $authenticate_user_use_case;
    private PullLocalPostContentUseCase $pull_local_post_content_use_case;
    private GetLocalPostContentByIdUseCase $get_local_post_content_by_id_use_case;
    private CreateCommentUseCase $create_comment_use_case;
    private GetRolesByIdUseCase $get_roles_by_id_use_case;
    private SyncRolesUseCase $sync_roles_use_case;
    private GetRoleSyncDataUseCase $get_role_sync_data_use_case;
    private SendRoleChunkSyncUseCase $send_role_chunk_sync_use_case;
    private GetPagesByIdUseCase $get_pages_by_id_use_case;
    private GetPageSyncDataUseCase $get_page_sync_data_use_case;
    private PageDeleteUseCase $page_delete_use_case;
    private PageSaveUseCase $page_save_use_case;
    private SendPageChunkSyncUseCase $send_page_chunk_sync_use_case;
    private SyncPagesUseCase $sync_pages_use_case;
    private PageUseCaseManager $page_use_case_manager;
    private PostUseCaseManager $post_use_case_manager;
    private AppSettingsUseCaseManager $app_settings_use_case_manager;
    private PointOfInterestUseCaseManager $point_of_interest_use_case_manager;

    public function __construct( BackendClient $backend_client, SelfClient $self_client ) {
        $this->get_android_asset_link_use_case         = new GetAndroidAssetLinkUseCase();
        $this->get_apple_app_site_association_use_case = new GetAppleAppSiteAssociationUseCase();
        $this->get_logs_use_case                       = new GetLogsUseCase();
        $this->get_blog_info_use_case                  = new GetBlogInfoUseCase();
        $this->is_logged_in_use_case                   = new IsLoggedInUseCase();
        $this->delete_session_use_case                 = new DeleteSessionUseCase( $backend_client );
        $this->register_blog_use_case                  = new RegisterBlogUseCase( $backend_client );
        $this->category_save_use_case                  = new CategorySaveUseCase( $backend_client );
        $this->category_delete_use_case                = new CategoryDeleteUseCase( $backend_client );
        $this->tag_delete_use_case                     = new TagDeleteUseCase( $backend_client );
        $this->tag_save_use_case                       = new TagSaveUseCase( $backend_client );
        $this->get_posts_by_id_use_case                = new GetPostsByIdUseCase();
        $this->get_tag_sync_data_use_case              = new GetTagSyncDataUseCase();
        $this->send_tag_chunk_sync_use_case            = new SendTagChunkSyncUseCase( $backend_client );
        $this->get_tags_by_id_use_case                 = new GetTagsByIdUseCase();
        $this->send_category_chunk_sync_use_case       = new SendCategoryChunkSyncUseCase( $backend_client );
        $this->get_category_sync_data_use_case         = new GetCategorySyncDataUseCase();
        $this->get_categories_by_id_use_case           = new GetCategoriesByIdUseCase();
        $this->send_attachment_chunk_sync_use_case     = new SendAttachmentChunkSyncUseCase( $backend_client );
        $this->get_attachments_by_id_use_case          = new GetAttachmentsByIdUseCase();
        $this->get_attachment_sync_data_use_case       = new GetAttachmentSyncDataUseCase();
        $this->send_comment_chunk_sync_use_case        = new SendCommentChunkSyncUseCase( $backend_client );
        $this->get_comments_by_id_use_case             = new GetCommentsByIdUseCase();
        $this->comment_save_use_case                   = new CommentSaveUseCase( $backend_client );
        $this->get_comment_sync_data_use_case          = new GetCommentSyncDataUseCase();
        $this->logout_user_use_case                    = new LogoutUserUseCase( $backend_client );
        $this->get_users_by_id_use_case                = new GetUsersByIdUseCase();
        $this->get_user_sync_data_use_case             = new GetUserSyncDataUseCase();
        $this->send_user_chunk_sync_use_case           = new SendUserChunkSyncUseCase( $backend_client );
        $this->sync_users_use_case                     = new SyncUsersUseCase( $this->get_user_sync_data_use_case, $this->send_user_chunk_sync_use_case );
        $this->sync_comments_use_case                  = new SyncCommentsUseCase( $this->get_comment_sync_data_use_case, $this->send_comment_chunk_sync_use_case );
        $this->sync_tags_use_case                      = new SyncTagsUseCase( $this->get_tag_sync_data_use_case, $this->send_tag_chunk_sync_use_case );
        $this->sync_categories_use_case                = new SyncCategoriesUseCase( $this->get_category_sync_data_use_case, $this->send_category_chunk_sync_use_case );
        $this->sync_attachments_use_case               = new SyncAttachmentsUseCase( $this->get_attachment_sync_data_use_case, $this->send_attachment_chunk_sync_use_case );
        $this->post_delete_use_case                    = new PostDeleteUseCase( $backend_client );
        $this->comment_delete_use_case                 = new CommentDeleteUseCase( $backend_client );
        $this->attachment_delete_use_case              = new AttachmentDeleteUseCase( $backend_client );
        $this->attachment_save_use_case                = new AttachmentSaveUseCase( $backend_client );
        $this->user_delete_use_case                    = new UserDeleteUseCase( $backend_client );
        $this->user_save_use_case                      = new UserSaveUseCase( $backend_client );
        $this->clear_logs_use_case                     = new ClearLogsUseCase();
        $this->authenticate_user_use_case              = new AuthenticateUserUseCase();
        $this->pull_local_post_content_use_case        = new PullLocalPostContentUseCase( $self_client );
        $this->get_local_post_content_by_id_use_case   = new GetLocalPostContentByIdUseCase();
        $this->get_post_contents_by_id_use_case        = new GetPostContentsByIdUseCase( $this->pull_local_post_content_use_case );
        $this->create_comment_use_case                 = new CreateCommentUseCase();
        $this->get_roles_by_id_use_case                = new GetRolesByIdUseCase();
        $this->get_role_sync_data_use_case             = new GetRoleSyncDataUseCase();
        $this->send_role_chunk_sync_use_case           = new SendRoleChunkSyncUseCase( $backend_client );
        $this->sync_roles_use_case                     = new SyncRolesUseCase( $this->get_role_sync_data_use_case, $this->send_role_chunk_sync_use_case );
        $this->get_pages_by_id_use_case                = new GetPagesByIdUseCase();
        $this->get_page_sync_data_use_case             = new GetPageSyncDataUseCase();
        $this->page_delete_use_case                    = new PageDeleteUseCase( $backend_client );
        $this->page_save_use_case                      = new PageSaveUseCase( $backend_client );
        $this->send_page_chunk_sync_use_case           = new SendPageChunkSyncUseCase( $backend_client );
        $this->sync_pages_use_case                     = new SyncPagesUseCase( $this->get_page_sync_data_use_case, $this->send_page_chunk_sync_use_case );
        $this->page_use_case_manager                   = new PageUseCaseManager( $self_client );
        $this->post_use_case_manager                   = new PostUseCaseManager( $backend_client );
        $this->app_settings_use_case_manager           = new AppSettingsUseCaseManager( $backend_client );
        $this->point_of_interest_use_case_manager      = new PointOfInterestUseCaseManager( $backend_client );
        $this->sync_all_use_case                       = new SyncAllUseCase( $this->post_use_case_manager->get_sync_posts_use_case(), $this->sync_tags_use_case, $this->sync_categories_use_case, $this->sync_attachments_use_case, $this->sync_comments_use_case, $this->sync_users_use_case, $this->sync_roles_use_case, $this->sync_pages_use_case, $this->points_of_interest()->get_sync_points_of_interest_use_case() );
    }

    public function get_android_asset_link_use_case(): GetAndroidAssetLinkUseCase {
        return $this->get_android_asset_link_use_case;
    }

    public function get_apple_app_site_association_use_case(): GetAppleAppSiteAssociationUseCase {
        return $this->get_apple_app_site_association_use_case;
    }

    public function get_logs_use_case(): GetLogsUseCase {
        return $this->get_logs_use_case;
    }

    public function get_blog_info_use_case(): GetBlogInfoUseCase {
        return $this->get_blog_info_use_case;
    }

    public function is_logged_in_use_case(): IsLoggedInUseCase {
        return $this->is_logged_in_use_case;
    }

    public function delete_session_use_case(): DeleteSessionUseCase {
        return $this->delete_session_use_case;
    }

    public function register_blog_use_case(): RegisterBlogUseCase {
        return $this->register_blog_use_case;
    }

    public function category_save_use_case(): CategorySaveUseCase {
        return $this->category_save_use_case;
    }

    public function category_delete_use_case(): CategoryDeleteUseCase {
        return $this->category_delete_use_case;
    }

    public function tag_delete_use_case(): TagDeleteUseCase {
        return $this->tag_delete_use_case;
    }

    public function tag_save_use_case(): TagSaveUseCase {
        return $this->tag_save_use_case;
    }

    public function get_posts_by_id_use_case(): GetPostsByIdUseCase {
        return $this->get_posts_by_id_use_case;
    }

    public function get_tag_sync_data_use_case(): GetTagSyncDataUseCase {
        return $this->get_tag_sync_data_use_case;
    }

    public function send_tag_chunk_sync_use_case(): SendTagChunkSyncUseCase {
        return $this->send_tag_chunk_sync_use_case;
    }

    public function get_tags_by_id_use_case(): GetTagsByIdUseCase {
        return $this->get_tags_by_id_use_case;
    }

    public function send_category_chunk_sync_use_case(): SendCategoryChunkSyncUseCase {
        return $this->send_category_chunk_sync_use_case;
    }

    public function get_category_sync_data_use_case(): GetCategorySyncDataUseCase {
        return $this->get_category_sync_data_use_case;
    }

    public function get_categories_by_id_use_case(): GetCategoriesByIdUseCase {
        return $this->get_categories_by_id_use_case;
    }

    public function send_attachment_chunk_sync_use_case(): SendAttachmentChunkSyncUseCase {
        return $this->send_attachment_chunk_sync_use_case;
    }

    public function send_comment_chunk_sync_use_case(): SendCommentChunkSyncUseCase {
        return $this->send_comment_chunk_sync_use_case;
    }

    public function get_attachments_by_id_use_case(): GetAttachmentsByIdUseCase {
        return $this->get_attachments_by_id_use_case;
    }

    public function comment_save_use_case(): CommentSaveUseCase {
        return $this->comment_save_use_case;
    }

    public function get_comment_sync_data_use_case(): GetCommentSyncDataUseCase {
        return $this->get_comment_sync_data_use_case;
    }

    public function get_attachment_sync_data_use_case(): GetAttachmentSyncDataUseCase {
        return $this->get_attachment_sync_data_use_case;
    }

    public function get_comments_by_id_use_case(): GetCommentsByIdUseCase {
        return $this->get_comments_by_id_use_case;
    }

    public function logout_user_use_case(): LogoutUserUseCase {
        return $this->logout_user_use_case;
    }

    public function sync_comments_use_case(): SyncCommentsUseCase {
        return $this->sync_comments_use_case;
    }

    public function sync_tags_use_case(): SyncTagsUseCase {
        return $this->sync_tags_use_case;
    }

    public function sync_categories_use_case(): SyncCategoriesUseCase {
        return $this->sync_categories_use_case;
    }

    public function sync_attachments_use_case(): SyncAttachmentsUseCase {
        return $this->sync_attachments_use_case;
    }

    public function sync_all_use_case(): SyncAllUseCase {
        return $this->sync_all_use_case;
    }

    public function post_delete_use_case(): PostDeleteUseCase {
        return $this->post_delete_use_case;
    }

    public function comment_delete_use_case(): CommentDeleteUseCase {
        return $this->comment_delete_use_case;
    }

    public function attachment_delete_use_case(): AttachmentDeleteUseCase {
        return $this->attachment_delete_use_case;
    }

    public function attachment_save_use_case(): AttachmentSaveUseCase {
        return $this->attachment_save_use_case;
    }

    public function get_users_by_id_use_case(): GetUsersByIdUseCase {
        return $this->get_users_by_id_use_case;
    }

    public function get_user_sync_data_use_case(): GetUserSyncDataUseCase {
        return $this->get_user_sync_data_use_case;
    }

    public function send_user_chunk_sync_use_case(): SendUserChunkSyncUseCase {
        return $this->send_user_chunk_sync_use_case;
    }

    public function user_delete_use_case(): UserDeleteUseCase {
        return $this->user_delete_use_case;
    }

    public function user_save_use_case(): UserSaveUseCase {
        return $this->user_save_use_case;
    }

    public function sync_users_use_case(): SyncUsersUseCase {
        return $this->sync_users_use_case;
    }

    public function get_post_contents_by_id_use_case(): GetPostContentsByIdUseCase {
        return $this->get_post_contents_by_id_use_case;
    }

    public function get_clear_logs_use_case(): ClearLogsUseCase {
        return $this->clear_logs_use_case;
    }

    public function get_authenticate_user_use_case(): AuthenticateUserUseCase {
        return $this->authenticate_user_use_case;
    }

    public function get_pull_local_post_content_use_case(): PullLocalPostContentUseCase {
        return $this->pull_local_post_content_use_case;
    }

    public function get_get_local_post_content_by_id_use_case(): GetLocalPostContentByIdUseCase {
        return $this->get_local_post_content_by_id_use_case;
    }

    public function create_comment_use_case(): CreateCommentUseCase {
        return $this->create_comment_use_case;
    }

    public function get_roles_by_id_use_case(): GetRolesByIdUseCase {
        return $this->get_roles_by_id_use_case;
    }

    public function get_role_sync_data_use_case(): GetRoleSyncDataUseCase {
        return $this->get_role_sync_data_use_case;
    }

    public function send_role_chunk_sync_use_case(): SendRoleChunkSyncUseCase {
        return $this->send_role_chunk_sync_use_case;
    }

    public function sync_roles_use_case(): SyncRolesUseCase {
        return $this->sync_roles_use_case;
    }

    public function get_pages_by_id_use_case(): GetPagesByIdUseCase {
        return $this->get_pages_by_id_use_case;
    }

    public function get_page_sync_data_use_case(): GetPageSyncDataUseCase {
        return $this->get_page_sync_data_use_case;
    }

    public function page_delete_use_case(): PageDeleteUseCase {
        return $this->page_delete_use_case;
    }

    public function page_save_use_case(): PageSaveUseCase {
        return $this->page_save_use_case;
    }

    public function send_page_chunk_sync_use_case(): SendPageChunkSyncUseCase {
        return $this->send_page_chunk_sync_use_case;
    }

    public function sync_pages_use_case(): SyncPagesUseCase {
        return $this->sync_pages_use_case;
    }

    public function pages(): PageUseCaseManager {
        return $this->page_use_case_manager;
    }

    public function posts(): PostUseCaseManager {
        return $this->post_use_case_manager;
    }

    public function app_settings(): AppSettingsUseCaseManager {
        return $this->app_settings_use_case_manager;
    }

    public function points_of_interest(): PointOfInterestUseCaseManager {
        return $this->point_of_interest_use_case_manager;
    }
}
