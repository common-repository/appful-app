<?php

namespace AppfulPlugin\Helper;

use AppfulPlugin\Wp\WPOptionsManager;

class ClientTokenManager {
	public static function createSession(): string {
		$token = md5( uniqid( mt_rand(), true ) );
		WPOptionsManager::save_client_token( $token );

		return $token;
	}

	public static function deleteSession() {
		WPOptionsManager::delete_client_token();
	}

	public static function getToken(): ?string {
		return WPOptionsManager::get_client_token();
	}

	public static function validateToken( string $session ): bool {
		return WPOptionsManager::get_client_token() === $session;
	}
}
