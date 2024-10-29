<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\UseCases\PointOfInterest\SyncPointsOfInterestUseCase;
use AppfulPlugin\UseCases\Post\SyncPostsUseCase;

class SyncAllUseCase {
    private SyncPostsUseCase $sync_posts_use_case;
    private SyncTagsUseCase $sync_tags_use_case;
    private SyncCategoriesUseCase $sync_categories_use_case;
    private SyncAttachmentsUseCase $sync_attachments_use_case;
    private SyncCommentsUseCase $sync_comments_use_case;
    private SyncUsersUseCase $sync_users_use_case;
    private SyncRolesUseCase $sync_roles_use_case;
    private SyncPagesUseCase $sync_pages_use_case;
    private SyncPointsOfInterestUseCase $sync_points_of_interest_use_case;

    public function __construct(
        SyncPostsUseCase $sync_posts_use_case,
        SyncTagsUseCase $sync_tags_use_case,
        SyncCategoriesUseCase $sync_categories_use_case,
        SyncAttachmentsUseCase $sync_attachments_use_case,
        SyncCommentsUseCase $sync_comments_use_case,
        SyncUsersUseCase $sync_users_use_case,
        SyncRolesUseCase $sync_roles_use_case,
        SyncPagesUseCase $sync_pages_use_case,
        SyncPointsOfInterestUseCase $sync_points_of_interest_use_case
    ) {
        $this->sync_posts_use_case              = $sync_posts_use_case;
        $this->sync_tags_use_case               = $sync_tags_use_case;
        $this->sync_categories_use_case         = $sync_categories_use_case;
        $this->sync_attachments_use_case        = $sync_attachments_use_case;
        $this->sync_comments_use_case           = $sync_comments_use_case;
        $this->sync_users_use_case              = $sync_users_use_case;
        $this->sync_roles_use_case              = $sync_roles_use_case;
        $this->sync_pages_use_case              = $sync_pages_use_case;
        $this->sync_points_of_interest_use_case = $sync_points_of_interest_use_case;
    }

    public function invoke() {
        $this->sync_users_use_case->invoke();
        $this->sync_roles_use_case->invoke();
        $this->sync_pages_use_case->invoke();
        $this->sync_categories_use_case->invoke();
        $this->sync_tags_use_case->invoke();
        $this->sync_attachments_use_case->invoke();
        $this->sync_posts_use_case->invoke();
        $this->sync_points_of_interest_use_case->invoke();
        $this->sync_comments_use_case->invoke();
    }
}
