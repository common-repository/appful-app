<?php

namespace AppfulPlugin\UseCases;

use AppfulPlugin\Domain\AuthenticateRequest;
use AppfulPlugin\Wp\WPUserManager;

class AuthenticateUserUseCase {
	public function invoke( AuthenticateRequest $request ): ?int {
		return WPUserManager::authenticate( $request->get_username(), $request->get_password() );
	}
}
