<?php

namespace AppfulPlugin\Api\Requests;

use AppfulPlugin\Helper\Constants;

class HttpRequest {
	private string $path = "/";
	private string $version = "";
	private $body = null;
	private array $headers = [];
	private array $params = [];
	private string $method = "GET";
	private bool $encoded = true;

	public static function backend_request(
		string $path = "/",
		$body = null,
		string $method = "GET",
		array $headers = [],
		bool $encoded = true,
		?string $version = null,
		array $params = []
	): HttpRequest {
		return ( new HttpRequest() )
			->path( $path )
			->body( $body )
			->method( $method )
			->headers( $headers )
			->encoded( $encoded )
			->version( $version ?? Constants::$API_VERSION_1 )
			->params( $params );
	}

	public function encoded( bool $encoded ): HttpRequest {
		$this->encoded = $encoded;

		return $this;
	}

	public function headers( array $headers ): HttpRequest {
		$this->headers = $headers;

		return $this;
	}

	public function header( string $key, string $value ): HttpRequest {
		$this->headers[ $key ] = $value;

		return $this;
	}

	public function params( array $params ): HttpRequest {
		$this->params = $params;

		return $this;
	}

	public function method( string $action ): HttpRequest {
		$this->method = $action;

		return $this;
	}

	public function body( $body ): HttpRequest {
		$this->body = $body;

		return $this;
	}

	public function path( string $path ): HttpRequest {
		$this->path = $path;

		return $this;
	}

	public function version( string $version ): HttpRequest {
		$this->version = $version;

		return $this;
	}

	public function get_method(): string {
		return $this->method;
	}

	public function get_body() {
		if ( $this->encoded && $this->body != null ) {
			return json_encode( $this->body );
		} else {
			return esc_html( $this->body );
		}
	}

	public function get_headers(): array {
		return $this->headers;
	}

	public function get_params(): array {
		return $this->params;
	}

	public function get_path(): string {
		return esc_url( $this->path );
	}

	public function get_version(): string {
		return $this->version;
	}

	public function has_header( string $key ): bool {
		return array_key_exists( $key, $this->headers );
	}
}