<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Tag;
use AppfulPlugin\Wp\WPAttachmentManager;
use AppfulPlugin\Wp\WPTagManager;
use WP_Term;

class TagMapper {
	public static function to_domain( WP_Term $tag ): Tag {
		return Tag::tag()
		          ->id( $tag->term_id )
		          ->description( $tag->description )
		          ->slug( $tag->slug )
		          ->title( html_entity_decode($tag->name) )
		          ->language( WPTagManager::get_tag_language( $tag->term_id ) )
		          ->image( WPAttachmentManager::get_image_for_term_id( $tag->term_id ) );
	}
}