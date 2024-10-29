<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Wp\WPOptionsManager;

class GetAndroidAssetLinkUseCase {
	public function invoke(): ?array {
		$asset_link_info = WPOptionsManager::get_android_asset_link();

		return [
			[
				"relation" => [ "delegate_permission/common.handle_all_urls" ],
				"target"   => [
					"namespace"                => "android_app",
					"package_name"             => "TODO",
					"sha256_cert_fingerprints" => [ "TODO" ],
				],
			],
		];
	}
}
