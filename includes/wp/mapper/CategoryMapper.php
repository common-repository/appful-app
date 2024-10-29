<?php

namespace AppfulPlugin\Wp\Mapper;

use AppfulPlugin\Domain\Category;
use AppfulPlugin\Wp\WPAttachmentManager;
use AppfulPlugin\Wp\WPCategoryManager;
use WP_Term;

class CategoryMapper {
	public static function to_domain( WP_Term $category ): Category {

		return Category::category()
		               ->id( $category->term_id )
		               ->description( $category->description )
		               ->slug( $category->slug )
		               ->title( html_entity_decode($category->name) )
		               ->parent( ( $category->parent != 0 ) ? self::to_domain( get_term( $category->parent ) ) : null )
		               ->language( WPCategoryManager::get_category_language( $category->term_id ) )
		               ->image( WPAttachmentManager::get_image_for_term_id( $category->term_id ) );
	}
}