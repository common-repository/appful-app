<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\BlogInfoDto;
use AppfulPlugin\Domain\BlogInfo;

class BlogInfoMapper {
    public static function to_dto( BlogInfo $blog_info ): BlogInfoDto {
        if ( $blog_info->get_stats() == null ) {
            $stats = null;
        } else {
            $stats = BlogStatsMapper::to_dto( $blog_info->get_stats() );
        }

        if ( $blog_info->get_hooks() == null ) {
            $hooks = null;
        } else {
            $hooks = BlogHooksMapper::to_dto( $blog_info->get_hooks() );
        }

        if ( $blog_info->get_settings() == null ) {
            $settings = null;
        } else {
            $settings = BlogSettingsMapper::to_dto( $blog_info->get_settings() );
        }

        return new BlogInfoDto(
            $blog_info->get_hostname(),
            $blog_info->get_site_url(),
            $blog_info->get_languages(),
            $blog_info->get_token(),
            $hooks,
            "3.1.24",
            $stats,
            $settings
        );
    }
}
