<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\WPPostManager;
use WP_Comment;

class CommentMapper {
	public static function to_domain( WP_Comment $comment ): Comment {
		return Comment::comment()
		              ->id( $comment->comment_ID )
		              ->post( WPPostManager::get_post_for_id( $comment->comment_post_ID ) )
		              ->author_name( $comment->comment_author )
		              ->author_mail( $comment->comment_author_email )
		              ->date( DateParser::fromGmtDate( $comment->comment_date_gmt ) )
		              ->content( $comment->comment_content )
		              ->status( wp_get_comment_status( $comment->comment_ID ) )
		              ->parent( ( $comment->comment_parent != 0 ) ? self::to_domain( get_comment( $comment->comment_parent ) ) : null );
	}
}
