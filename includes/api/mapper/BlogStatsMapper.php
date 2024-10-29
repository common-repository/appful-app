<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\BlogStatsDto;
use AppfulPlugin\Domain\BlogStats;

class BlogStatsMapper {
	public static function to_dto( BlogStats $stats ): BlogStatsDto {
		return new BlogStatsDto(
			$stats->get_attachment_count(),
			$stats->get_post_count(),
			$stats->get_user_count(),
			$stats->get_page_count(),
			$stats->get_comment_count()
		);
	}
}
