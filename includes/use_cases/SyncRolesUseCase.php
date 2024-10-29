<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Role;
use AppfulPlugin\Domain\SyncChunk;
use AppfulPlugin\Domain\SyncItem;
use AppfulPlugin\Helper\Constants;

class SyncRolesUseCase {
	private GetRoleSyncDataUseCase $get_role_sync_data_use_case;
	private SendRoleChunkSyncUseCase $send_role_chunk_sync_use_case;

	public function __construct(
		GetRoleSyncDataUseCase $get_role_sync_data_use_case,
		SendRoleChunkSyncUseCase $send_role_chunk_sync_use_case
	) {
		$this->get_role_sync_data_use_case   = $get_role_sync_data_use_case;
		$this->send_role_chunk_sync_use_case = $send_role_chunk_sync_use_case;
	}

	public function invoke() {
		$roles = $this->get_role_sync_data_use_case->invoke();

		$sync_items = array_map(
			function ( Role $role ) {
				return SyncItem::syncItem()
				               ->id( $role->get_id() );
			},
			$roles
		);

		$sync_id    = uniqid();
		$batch_size = count( $sync_items );
		$chunk_size = Constants::$ROLE_SYNC_CHUNK_SIZE;

		foreach ( array_chunk( $sync_items, $chunk_size ) as $tag_chunk ) {
			$this->send_role_chunk_sync_use_case->invoke(
				SyncChunk::syncChunk()
				         ->batch_id( $sync_id )
				         ->chunk_size( $chunk_size )
				         ->batch_size( $batch_size )
				         ->chunk_items( $tag_chunk )
			);
		}
	}
}
