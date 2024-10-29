<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\PageContentDto;
use AppfulPlugin\Domain\PageContent;

class PageContentMapper {
	public static function to_dto( PageContent $page_content ): PageContentDto {
		return new PageContentDto(
			$page_content->get_id(),
			$page_content->get_head(),
			$page_content->get_footer(),
			$page_content->get_content(),
			$page_content->get_body_class()
		);
	}
}
