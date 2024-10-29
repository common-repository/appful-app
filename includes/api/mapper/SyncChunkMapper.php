<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\SyncChunkDto;
use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Domain\SyncItem;

class SyncChunkMapper {
	public static function to_dto( SyncChunk $sync_chunk ): SyncChunkDto {
		$sync_items = array_map(
			function ( SyncItem $sync_item ) {
				return SyncItemMapper::to_dto( $sync_item );
			},
			$sync_chunk->get_chunk_items()
		);

		return new SyncChunkDto(
			$sync_chunk->get_batch_id(),
			$sync_chunk->get_batch_size(),
			$sync_chunk->get_chunk_size(),
			$sync_items
		);
	}
}
