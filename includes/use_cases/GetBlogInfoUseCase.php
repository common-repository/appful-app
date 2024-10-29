<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\BlogInfo;
use AppfulPlugin\Wp\WPBlogManager;

class GetBlogInfoUseCase {
	public function invoke(): BlogInfo {
		return WPBlogManager::get_blog_info();
	}
}