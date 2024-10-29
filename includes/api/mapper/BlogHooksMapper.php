<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\BlogHooksDto;
use AppfulPlugin\Domain\BlogHooks;

class BlogHooksMapper {
	public static function to_dto( BlogHooks $blog_hooks ): BlogHooksDto {
		return new BlogHooksDto(
			$blog_hooks->get_create_comment(),
			$blog_hooks->get_authenticate_user(),
			$blog_hooks->get_get_page_content()
		);
	}
}
