<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\SyncItemDto;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\DateParser;

class SyncItemMapper {
	public static function to_dto( SyncItem $sync_item ): SyncItemDto {
		return new SyncItemDto(
			$sync_item->get_id(),
			DateParser::dateToString( $sync_item->get_modified() ),
			$sync_item->get_force_update(),
		);
	}
}