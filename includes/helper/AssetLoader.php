<?php

namespace AppfulPlugin\Helper;

class AssetLoader {
	public static function load_asset_url( string $asset ): string {
		return plugins_url( '../../frontend/assets/' . $asset, __FILE__ );
	}

	public static function load_style_url( string $style ): string {
		return plugins_url( '../../frontend/styles/' . $style, __FILE__ );
	}

	public static function load_script_url( string $script ): string {
		return plugins_url( '../../frontend/scripts/' . $script, __FILE__ );
	}
}