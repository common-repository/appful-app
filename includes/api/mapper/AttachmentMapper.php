<?php

namespace AppfulPlugin\Api\Mapper;

use AppfulPlugin\Api\Dtos\AttachmentDto;
use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Helper\DateParser;

class AttachmentMapper {
	public static function to_dto( Attachment $attachment ): AttachmentDto {
		return new AttachmentDto(
			$attachment->get_id(),
			$attachment->get_title(),
			$attachment->get_url(),
			$attachment->get_width(),
			$attachment->get_height(),
			$attachment->get_size(),
			$attachment->get_language(),
			DateParser::dateToString( $attachment->get_modified() ),
			DateParser::dateToString( $attachment->get_date() )
		);
	}
}