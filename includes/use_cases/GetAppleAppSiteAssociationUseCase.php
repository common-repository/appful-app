<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Wp\WPOptionsManager;

class GetAppleAppSiteAssociationUseCase {
	public function invoke(): ?array {
		$app_site_association_info = WPOptionsManager::get_apple_app_site_association();

		return [
			"applinks" => [
				"details" => [
					[
						"appsIDs"    => [ "TODO" ],
						"components" => [
							"TODO",
						],
					],
				],
			],
			"appclips" => [
				"apps" => [ "TODO" ],
			],
		];
	}
}