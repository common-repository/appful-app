<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\Comment;
use AppfulPlugin\Domain\CreateCommentRequest;
use AppfulPlugin\Wp\WPCommentManager;

class CreateCommentUseCase {
	public function invoke( CreateCommentRequest $request ): ?Comment {
		return WPCommentManager::create_comment( $request );
	}
}
