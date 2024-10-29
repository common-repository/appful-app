<?php

namespace AppfulPlugin\Api\Client;

use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Api\Responses\HttpResponse;
use AppfulPlugin\Helper\Constants;
use AppfulPlugin\Helper\Logger;
use AppfulPlugin\Wp\WPOptionsManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class BackendClient {
	private Client $client;

	public function __construct() {
		$this->client = new Client( [
			"base_uri"    => Constants::$APPFUL_API_URL,
			"headers"     => [
				"content-type" => "application/json",
				"Accept"       => "application/json"
			],
			"http_errors" => false,
		] );
	}

	public function send_request( HttpRequest $backend_request, bool $logout_on_error = true ): HttpResponse {
		try {
			if ( ! $backend_request->has_header( "Authorization" ) ) {
				$backend_request->header( "Authorization", "Bearer " . WPOptionsManager::get_session_id() );
			}

			$base_uri     = new Uri( $backend_request->get_version() . $backend_request->get_path() );
			$request_path = Uri::withQueryValues( $base_uri, $backend_request->get_params() );

			$request  = new Request( $backend_request->get_method(), $request_path, $backend_request->get_headers(), $backend_request->get_body() );
			$response = $this->client->send( $request );

			if ( $response->getStatusCode() != 200 ) {
				Logger::error( "Received non 200 status code (" . $response->getStatusCode() . ") for request path: " . $request_path . " with request body: " . $backend_request->get_body() );
				$response_body = [ "error" => $response->getBody() ];
			} else {
				$response_body = json_decode( $response->getBody(), true );
			}

			if ( $response->getStatusCode() == 401 && $logout_on_error ) {
				// Our session id is no longer valid with the backend - log out the user
				do_action( "appful_logout" );
			}

			return HttpResponse::backend_response()->body( $response_body )->status( $response->getStatusCode() );
		} catch ( GuzzleException $e ) {
			Logger::error( "Error happened when trying to execute backend request: " . $e->getMessage() );

			return HttpResponse::backend_response()->status( 500 );
		}
	}
}