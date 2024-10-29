<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Wp\WPOptionsManager;

class IsLoggedInUseCase {
	public function invoke(): bool {
		return WPOptionsManager::get_session_id() != null && WPOptionsManager::get_client_token() != null;
	}
}