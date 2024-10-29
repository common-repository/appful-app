<?php

namespace AppfulPlugin\Api\Requests;

use AppfulPlugin\Api\Endpoints;

class PluginRequest {
	private string $action = "";
	private string $token = "";

	public static function plugin_request(
		string $action = "",
		string $token = ""
	): PluginRequest {
		return ( new PluginRequest() )->action( $action )->token( $token );
	}

	public function token( string $token ): PluginRequest {
		$this->token = $token;

		return $this;
	}

	public function action( string $action ): PluginRequest {
		$this->action = $action;

		return $this;
	}

	public function get_action(): string {
		return $this->action;
	}

	public function get_token(): string {
		return $this->token;
	}

	public function requires_auth(): bool {
		return !in_array( $this->action, [ Endpoints::$SITE_ASSOCIATION, Endpoints::$ASSET_LINKS ] );
	}
}
