<?php

namespace AppfulPlugin\Wp;

use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Domain\CreateCommentRequest;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\Wp\Mapper\CommentMapper;
use AppfulPlugin\Wp\Plugins\LanguageHelper;
use WP_Comment;

class WPCommentManager {
    public static function get_comment_count(): int {
        return WPCommentDatabaseManager::get_count();
    }

    /** @return SyncItem[] */
    public static function get_comment_sync_items( int $offset, int $count ): array {
        return WPCommentDatabaseManager::get_sync_items( $count, $offset );
    }

    /**
     * @param int[] $ids
     *
     * @return Comment[]
     */
    public static function get_comments_by_id( array $ids ): array {
        $args = [
            "status" => array_keys( get_comment_statuses() ),
            "comment__in" => $ids
        ];

        $all_comments = LanguageHelper::for_each_language( function () use ( $args ) {
            return get_comments( $args );
        } );

        return array_map(
            function ( WP_Comment $comment ) {
                return CommentMapper::to_domain( $comment );
            },
            $all_comments
        );
    }

    public static function create_comment( CreateCommentRequest $request ): ?Comment {
        $commentData = [
            'comment_author' => $request->get_username(), // The name of the author of the comment.
            'comment_author_email' => $request->get_email(), // The email address of the $comment_author.
            'comment_content' => $request->get_content(), // The content of the comment.
            'comment_post_ID' => $request->get_post_id(), // ID of the post that relates to the comment.
            'comment_parent' => $request->get_parent_id(), // ID of this comment's parent, if any.
        ];

        $commentId = wp_insert_comment( $commentData );

        if ( $commentId === false ) {
            Logger::error( "Insert comment failed" );

            return null;
        }

        $comment = get_comment( $commentId );

        if ( !$comment instanceof WP_Comment ) {
            Logger::error( "Getting comment failed!" );

            return null;
        }

        return CommentMapper::to_domain( $comment );
    }
}