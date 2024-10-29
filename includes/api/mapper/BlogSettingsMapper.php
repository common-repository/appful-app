<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\BlogSettingsDto;
use AppfulPlugin\Domain\BlogSettings;

class BlogSettingsMapper {
    public static function to_dto( BlogSettings $settings ): BlogSettingsDto {
        return new BlogSettingsDto(
            $settings->get_post_sync_batch_size()
        );
    }
}
