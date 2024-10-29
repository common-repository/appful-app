<?php

namespace AppfulPlugin\Api;

use AppfulPlugin\Helper\Logger;

class Rewrites {
	public function enable_custom_vars() {
		add_filter(
			"query_vars",
			function ( array $vars ): array {
				return $this->add_appful_query_var( $vars );
			},
		);
	}

	private function add_appful_query_var( $vars ): array {
		if ( $vars == null ) {
			$vars = [];
		}

		$appful_vars = [
			"appful",
			"appful_action"
		];

		return array_merge( $appful_vars, $vars );
	}

	public function enable_rewrite() {
		Logger::debug( "Add filter for enabling rewrite rules" );
		add_filter(
			"rewrite_rules_array",
			function ( array $rules ): array {
				return $this->enabled_rewrite_rules( $rules );
			},
			10,
			1,
		);
		flush_rewrite_rules();
	}

	private function enabled_rewrite_rules( $rules ): array {
		Logger::debug( "Enabling rewrite rules" );

		if ( $rules == null ) {
			$rules = [];
		}

		$appful_rewrite_rules = [
			"^appful/api/?$"      => "index.php?appful=1&appful_action=info",
			"^appful/api/(.+)/?$" => "index.php?appful=1&appful_action=\$matches[1]"
		];

		$appful_apple_rewrite_rules = [
			"^.well-known/apple-app-site-association/?$" => "index.php?appful=1&appful_action=apple-app-site-association"
		];

		$appful_android_rewrite_rules = [
			"^.well-known/assetlinks.json/?$" => "index.php?appful=1&appful_action=android-asset-links"
		];

		return array_merge( $appful_rewrite_rules, $appful_apple_rewrite_rules, $appful_android_rewrite_rules, $rules );
	}

	public function disable_rewrite() {
		Logger::info( "Remove filter for enabling rewrite rules" );
		add_filter(
			"rewrite_rules_array",
			function ( array $rules ): array {
				return $this->disabled_rewrite_rules( $rules );
			},
			10,
			1,
		);
		flush_rewrite_rules();
	}

	private function disabled_rewrite_rules( $rules ): array {
		Logger::info( "Disabling rewrite rules" );

		if ( $rules == null ) {
			$rules = [];
		}

		return $rules;
	}
}