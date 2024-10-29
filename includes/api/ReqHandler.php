<?php

namespace AppfulPlugin\Api;

use AppfulPlugin\Api\Handlers\AndroidAssetLinkRequestHandler;
use AppfulPlugin\Api\Handlers\AppleAppSiteAssociationRequestHandler;
use AppfulPlugin\Api\Handlers\AttachmentSyncRequestHandler;
use AppfulPlugin\Api\Handlers\AuthenticateUserRequestHandler;
use AppfulPlugin\Api\Handlers\CategorySyncRequestHandler;
use AppfulPlugin\Api\Handlers\ClearLogRequestHandler;
use AppfulPlugin\Api\Handlers\CommentSyncRequestHandler;
use AppfulPlugin\Api\Handlers\CreateCommentRequestHandler;
use AppfulPlugin\Api\Handlers\GetAttachmentsRequestHandler;
use AppfulPlugin\Api\Handlers\GetCategoriesRequestHandler;
use AppfulPlugin\Api\Handlers\GetCommentsRequestHandler;
use AppfulPlugin\Api\Handlers\GetPageContentsRequestHandler;
use AppfulPlugin\Api\Handlers\GetPagesRequestHandler;
use AppfulPlugin\Api\Handlers\GetPostContentsRequestHandler;
use AppfulPlugin\Api\Handlers\GetPostsRequestHandler;
use AppfulPlugin\Api\Handlers\GetRolesRequestHandler;
use AppfulPlugin\Api\Handlers\GetTagsRequestHandler;
use AppfulPlugin\Api\Handlers\GetUsersRequestHandler;
use AppfulPlugin\Api\Handlers\InfoRequestHandler;
use AppfulPlugin\Api\Handlers\LogRequestHandler;
use AppfulPlugin\Api\Handlers\Page\GetPageContentRequestHandler;
use AppfulPlugin\Api\Handlers\PageSyncRequestHandler;
use AppfulPlugin\Api\Handlers\PointOfInterest\GetPointsOfInterestRequestHandler;
use AppfulPlugin\Api\Handlers\PointOfInterest\PointOfInterestSyncRequestHandler;
use AppfulPlugin\Api\Handlers\PostSyncRequestHandler;
use AppfulPlugin\Api\Handlers\PullLocalPageContentRequestHandler;
use AppfulPlugin\Api\Handlers\PullLocalPostContentRequestHandler;
use AppfulPlugin\Api\Handlers\RequestHandler;
use AppfulPlugin\Api\Handlers\RoleSyncRequestHandler;
use AppfulPlugin\Api\Handlers\SavePostSyncBatchSizeHandler;
use AppfulPlugin\Api\Handlers\SyncRequestHandler;
use AppfulPlugin\Api\Handlers\TagSyncRequestHandler;
use AppfulPlugin\Api\Handlers\UserSyncRequestHandler;
use AppfulPlugin\Api\Requests\PluginRequest;
use AppfulPlugin\Api\Responses\PluginResponse;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\UseCases\UseCaseManager;

class ReqHandler {
    private array $request_handlers;

    public function __construct( UseCaseManager $use_case_manager ) {
        $this->request_handlers = [
            new AndroidAssetLinkRequestHandler( $use_case_manager->get_android_asset_link_use_case() ),
            new AppleAppSiteAssociationRequestHandler( $use_case_manager->get_apple_app_site_association_use_case() ),
            new LogRequestHandler( $use_case_manager->get_logs_use_case() ),
            new InfoRequestHandler( $use_case_manager->get_blog_info_use_case() ),
            new PostSyncRequestHandler( $use_case_manager->posts()->get_sync_posts_use_case() ),
            new GetPostsRequestHandler( $use_case_manager->get_posts_by_id_use_case() ),
            new CategorySyncRequestHandler( $use_case_manager->sync_categories_use_case() ),
            new GetCategoriesRequestHandler( $use_case_manager->get_categories_by_id_use_case() ),
            new TagSyncRequestHandler( $use_case_manager->sync_tags_use_case() ),
            new GetTagsRequestHandler( $use_case_manager->get_tags_by_id_use_case() ),
            new GetAttachmentsRequestHandler( $use_case_manager->get_attachments_by_id_use_case() ),
            new AttachmentSyncRequestHandler( $use_case_manager->sync_attachments_use_case() ),
            new SyncRequestHandler( $use_case_manager->sync_all_use_case() ),
            new GetCommentsRequestHandler( $use_case_manager->get_comments_by_id_use_case() ),
            new CommentSyncRequestHandler( $use_case_manager->sync_comments_use_case() ),
            new UserSyncRequestHandler( $use_case_manager->sync_users_use_case() ),
            new GetUsersRequestHandler( $use_case_manager->get_users_by_id_use_case() ),
            new GetPostContentsRequestHandler( $use_case_manager->get_post_contents_by_id_use_case() ),
            new ClearLogRequestHandler( $use_case_manager->get_clear_logs_use_case() ),
            new AuthenticateUserRequestHandler( $use_case_manager->get_authenticate_user_use_case() ),
            new PullLocalPostContentRequestHandler( $use_case_manager->get_get_local_post_content_by_id_use_case() ),
            new CreateCommentRequestHandler( $use_case_manager->create_comment_use_case() ),
            new GetRolesRequestHandler( $use_case_manager->get_roles_by_id_use_case() ),
            new RoleSyncRequestHandler( $use_case_manager->sync_roles_use_case() ),
            new GetPagesRequestHandler( $use_case_manager->get_pages_by_id_use_case() ),
            new PageSyncRequestHandler( $use_case_manager->sync_pages_use_case() ),
            new GetPageContentsRequestHandler( $use_case_manager->pages()->get_page_contents_by_id_use_case() ),
            new PullLocalPageContentRequestHandler( $use_case_manager->pages()->get_local_page_content_by_id_use_case() ),
            new GetPageContentRequestHandler( $use_case_manager->pages()->pull_local_page_content_use_case() ),
            new PointOfInterestSyncRequestHandler( $use_case_manager->points_of_interest()->get_sync_points_of_interest_use_case() ),
            new GetPointsOfInterestRequestHandler( $use_case_manager->points_of_interest()->get_get_points_of_interest_by_id_use_case() ),
            new SavePostSyncBatchSizeHandler( $use_case_manager->posts()->get_save_post_sync_batch_size_use_case() )
        ];
    }

    public function handle_request( PluginRequest $request ): PluginResponse {
        foreach ( $this->request_handlers as $request_handler ) {
            if ( $request_handler instanceof RequestHandler ) {
                if ( $request_handler->can_handle_request( $request ) ) {
                    return $request_handler->handle_request( $request );
                }
            }
        }

        Logger::error( "Did not find handler for action: " . $request->get_action() );

        return PluginResponse::plugin_response()->status( 404 );
    }
}