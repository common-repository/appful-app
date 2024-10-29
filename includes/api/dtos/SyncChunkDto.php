<?php

namespace AppfulPlugin\Api\Dtos;

class SyncChunkDto {
	public string $batch_id = "";
	public int $batch_size = 0;
	public int $chunk_size = 0;
	/** @var SyncItemDto[] */
	public array $chunk_items = [];

	/**
	 * @param SyncItemDto[] $chunk_items
	 */
	public function __construct( string $batch_id, int $batch_total, int $chunk_size, array $chunk_items ) {
		$this->batch_id   = $batch_id;
		$this->batch_size = $batch_total;
		$this->chunk_size = $chunk_size;
		$this->chunk_items      = $chunk_items;
	}
}
