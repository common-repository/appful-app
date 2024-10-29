<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\PostDto;
use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Domain\Category;
use AppfulPlugin\Domain\Post;
use AppfulPlugin\Domain\Role;
use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Helper\DateParser;

class PostMapper {
	public static function to_dto( Post $post ): PostDto {
		$author = null;
		if ( $post->get_author() != null ) {
			$author = UserMapper::to_dto( $post->get_author() );
		}

		$thumbnail = null;
		if ( $post->get_thumbnail() != null ) {
			$thumbnail = AttachmentMapper::to_dto( $post->get_thumbnail() );
		}

		$categories = array_map(
			function ( Category $category ) {
				return CategoryMapper::to_dto( $category );
			},
			$post->get_categories()
		);

		$tags = array_map(
			function ( Tag $tag ) {
				return TagMapper::to_dto( $tag );
			},
			$post->get_tags()
		);

		$attachments = array_map(
			function ( Attachment $attachment ) {
				return AttachmentMapper::to_dto( $attachment );;
			},
			$post->get_attachments()
		);

		return new PostDto(
			$post->get_id(),
			$post->get_title(),
			$post->get_url(),
			$author,
			$categories,
			$tags,
			$thumbnail,
			$attachments,
			$post->get_status(),
			$post->get_language(),
			DateParser::dateToString( $post->get_modified() ),
			DateParser::dateToString( $post->get_date() ),
			$post->get_comment_status(),
			$post->get_sticky(),
			$post->get_send_push(),
			array_map(
				function ( Role $role ) {
					return RoleMapper::to_dto( $role );
				},
				$post->get_roles()
			),
		);
	}
}
