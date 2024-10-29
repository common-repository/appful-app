<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\CommentDto;
use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Helper\DateParser;

class CommentMapper {
	public static function to_dto( Comment $comment ): CommentDto {
		$post = null;
		if ( $comment->get_post() != null ) {
			$post = PostMapper::to_dto( $comment->get_post() );
		}

		return new CommentDto(
			$comment->get_id(),
			$post,
			$comment->get_author_name(),
			$comment->get_author_mail(),
			DateParser::dateToString( $comment->get_date() ),
			$comment->get_content(),
			$comment->get_status(),
			( $comment->get_parent() != null ) ? self::to_dto( $comment->get_parent() ) : null
		);
	}
}
