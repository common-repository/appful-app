<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Attachment;
use AppfulPlugin\Helper\DateParser;
use AppfulPlugin\Wp\WPAttachmentManager;
use WP_Post;

class AttachmentMapper {
	public static function to_domain( WP_Post $attachment ): Attachment {
		$attachment_meta = WPAttachmentManager::get_meta_for_attachment( $attachment->ID );
		$attachment_url  = WPAttachmentManager::get_url_for_attachment( $attachment->ID );

		if ( ! $attachment_meta ) {
			$width  = 0;
			$height = 0;
		} else {
			$width = $attachment_meta['width'];
			if ( is_null( $width ) ) {
				$width = 0;
			}
			$height = $attachment_meta['height'];
			if ( is_null( $height ) ) {
				$height = 0;
			}
		}

		return Attachment::attachment()
		                 ->id( $attachment->ID )
		                 ->width( $width )
		                 ->height( $height )
		                 ->title( $attachment->post_title )
		                 ->url( $attachment_url )
		                 ->language( WPAttachmentManager::get_attachment_language( $attachment->ID ) )
		                 ->modified( DateParser::fromGmtDate( $attachment->post_modified_gmt ) )
		                 ->date( DateParser::fromGmtDate( $attachment->post_date_gmt ) );
	}
}
