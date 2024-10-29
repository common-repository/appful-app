<?php

namespace AppfulPlugin\Api\Responses;

class PluginResponse {
	private int $status = 200;
	private $body = null;
	private bool $encoded = true;

	public static function plugin_response(
		$body = null,
		int $status = 200,
		bool $encoded = true
	): PluginResponse {
		return ( new PluginResponse() )->body( $body )->status( $status )->encoded( $encoded );
	}

	public function encoded( bool $encoded ): PluginResponse {
		$this->encoded = $encoded;

		return $this;
	}

	public function status( int $status ): PluginResponse {
		$this->status = $status;

		return $this;
	}

	public function body( $body ): PluginResponse {
		$this->body = $body;

		return $this;
	}

	public function get_encoded(): bool {
		return $this->encoded;
	}

	public function get_status(): int {
		return $this->status;
	}

	public function get_body() {
		if ( $this->encoded && ( is_array( $this->body ) || $this->body != null ) ) {
			return json_encode( $this->body );
		} else {
			return esc_html($this->body);
		}
	}
}