<?php

namespace AppfulPlugin\Domain;

class SyncChunk {
	private string $batch_id = "";
	private int $batch_size = 0;
	private int $chunk_size = 0;
	/** @var SyncItem[] */
	private array $chunk_items = [];

	/**
	 * @param SyncItem[] $chunk_items
	 */
	public static function syncChunk(
		string $batch_id = "",
		int $batch_size = 0,
		int $chunk_size = 0,
		array $chunk_items = []
	): SyncChunk {
		return ( new SyncChunk() )
			->batch_id( $batch_id )
			->batch_size( $batch_size )
			->chunk_size( $chunk_size )
			->chunk_items( $chunk_items );
	}

	public function batch_id( string $batch_id ): SyncChunk {
		$this->batch_id = $batch_id;

		return $this;
	}

	public function batch_size( int $batch_size ): SyncChunk {
		$this->batch_size = $batch_size;

		return $this;
	}

	public function chunk_size( int $chunk_size ): SyncChunk {
		$this->chunk_size = $chunk_size;

		return $this;
	}

	/**
	 * @param SyncItem[] $chunk_items
	 */
	public function chunk_items( array $chunk_items ): SyncChunk {
		$this->chunk_items = $chunk_items;

		return $this;
	}

	public function get_batch_id(): string {
		return $this->batch_id;
	}

	public function get_batch_size(): int {
		return $this->batch_size;
	}

	public function get_chunk_size(): int {
		return $this->chunk_size;
	}

	/**
	 * @return SyncItem[]
	 */
	public function get_chunk_items(): array {
		return $this->chunk_items;
	}
}
