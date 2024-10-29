<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\TagDto;
use AppfulPlugin\Domain\Tag;

class TagMapper {
	public static function to_dto( Tag $tag ): TagDto {
		$image = null;
		if ( $tag->get_image() != null ) {
			$image = AttachmentMapper::to_dto( $tag->get_image() );
		}

		return new TagDto(
			$tag->get_id(),
			$tag->get_slug(),
			$tag->get_title(),
			$tag->get_description(),
			$tag->get_language(),
			$image
		);
	}
}