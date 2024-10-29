<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\PostContentAssetDto;
use AppfulPlugin\Api\Dtos\PostContentDto;
use AppfulPlugin\Domain\PostContent;
use AppfulPlugin\Domain\PostContentAsset;

class PostContentMapper {
	public static function to_dto( PostContent $post_content ): PostContentDto {
		return new PostContentDto(
			$post_content->get_id(),
			$post_content->get_head(),
			$post_content->get_footer(),
			$post_content->get_content(),
			$post_content->get_body_class()
		);
	}
}
