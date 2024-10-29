<?php

namespace AppfulPlugin\Wp\Plugins;

use AppfulPlugin\Wp\WPBlogManager;

class LanguageHelper {
	public static function get_languages(): array {
		$languages = apply_filters( "appful_languages", null );

		if ( $languages == null ) {
			return [ WPBlogManager::get_blog_language() ];
		}

		return $languages;
	}

	private static function get_element_lang( int $object_id, string $object_type ): string {
		$args = [
			"element_id"   => $object_id,
			"element_type" => $object_type
		];

		$language = apply_filters( "appful_element_language", null, $args );

		if ( $language == null ) {
			return WPBlogManager::get_blog_language();
		}

		return $language;
	}

	public static function for_each_language( callable $callback ): array {
		$result = [];

		foreach ( self::get_languages() as $lang ) {
			self::switch_language( $lang );
			$result = array_merge( $result, $callback() );
		}
		self::switch_language( null );

		return $result;
	}

	public static function for_language( string $lang, callable $callback ) {
		self::switch_language( $lang );
		$res = $callback();
		self::switch_language( null );

		return $res;
	}

	private static function switch_language( ?string $lang ) {
		do_action( "appful_switch_language", $lang );
	}

	public static function get_post_language( int $post_id ): string {
		return self::get_element_lang( $post_id, "post" );
	}

	public static function get_page_language( int $post_id ): string {
		return self::get_element_lang( $post_id, "page" );
	}

	public static function get_category_language( int $term_id ): string {
		return self::get_element_lang( $term_id, "category" );
	}

	public static function get_attachment_language( int $attachment_id ): string {
		return self::get_element_lang( $attachment_id, "attachment" );
	}

	public static function get_tag_language( int $term_id ): string {
		return self::get_element_lang( $term_id, "post_tag" );
	}
}