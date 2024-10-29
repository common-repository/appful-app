<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\PageDto;
use AppfulPlugin\Domain\Page;
use AppfulPlugin\Domain\Role;
use AppfulPlugin\Helper\DateParser;

class PageMapper {
	public static function to_dto( Page $page ): PageDto {
		$author = null;
		if ( $page->get_author() != null ) {
			$author = UserMapper::to_dto( $page->get_author() );
		}

		$thumbnail = null;
		if ( $page->get_thumbnail() != null ) {
			$thumbnail = AttachmentMapper::to_dto( $page->get_thumbnail() );
		}

		return new PageDto(
			$page->get_id(),
			$page->get_title(),
			$page->get_url(),
			$author,
			$thumbnail,
			$page->get_status(),
			$page->get_language(),
			DateParser::dateToString( $page->get_modified() ),
			DateParser::dateToString( $page->get_date() ),
			$page->get_comment_status(),
			array_map(
				function ( Role $role ) {
					return RoleMapper::to_dto( $role );
				},
				$page->get_roles()
			),
		);
	}
}
