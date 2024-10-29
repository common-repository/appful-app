<?php

namespace AppfulPlugin\Api\Responses;

class HttpResponse {
	private int $status = 200;
	private ?array $body = null;

	public static function backend_response(
		?array $body = null,
		int $status = 200
	): HttpResponse {
		return ( new HttpResponse() )->body( $body )->status( $status );
	}

	public function status( int $status ): HttpResponse {
		$this->status = $status;

		return $this;
	}

	public function body( ?array $body ): HttpResponse {
		$this->body = $body;

		return $this;
	}

	public function get_status(): int {
		return $this->status;
	}

	public function get_body(): ?array {
		return $this->body;
	}
}