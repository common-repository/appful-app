<?php

namespace AppfulPlugin\UseCases\Page;

use AppfulPlugin\Domain\PageContent;
use AppfulPlugin\Wp\WPPageManager;

class GetLocalPageContentByIdUseCase {
	public function invoke( int $id, ?int $user_id = null ): ?PageContent {
		return WPPageManager::get_page_content_by_id( $id, $user_id );
	}
}
