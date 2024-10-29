<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\PostContent;

class GetPostContentsByIdUseCase {
	private PullLocalPostContentUseCase $pull_local_post_content_use_case;

	public function __construct( PullLocalPostContentUseCase $pull_local_post_content_use_case ) {
		$this->pull_local_post_content_use_case = $pull_local_post_content_use_case;
	}


	/**
	 * @param int[] $ids
	 *
	 * @return PostContent[]
	 */
	public function invoke( array $ids ): array {
		$post_contents = [];

		foreach ( $ids as $post_id ) {
			$response = $this->pull_local_post_content_use_case->invoke( $post_id );
			if ( $response != null ) {
				$post_contents[] = $response;
			}
		}

		return $post_contents;
	}
}
