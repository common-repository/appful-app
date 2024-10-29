<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\CategoryDto;
use AppfulPlugin\Domain\Category;

class CategoryMapper {
	public static function to_dto( Category $category ): CategoryDto {
		$image = null;
		if ( $category->get_image() != null ) {
			$image = AttachmentMapper::to_dto( $category->get_image() );
		}

		return new CategoryDto(
			$category->get_id(),
			$category->get_slug(),
			$category->get_title(),
			$category->get_description(),
			( $category->get_parent() != null ) ? self::to_dto( $category->get_parent() ) : null,
			$category->get_language(),
			$image
		);
	}
}