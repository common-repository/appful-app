<?php

namespace AppfulPlugin\Api\Client;

use AppfulPlugin\Api\Endpoints;
use AppfulPlugin\Api\Requests\HttpRequest;
use AppfulPlugin\Api\Responses\HttpResponse;
use AppfulPlugin\Helper\ClientTokenManager;
use AppfulPlugin\Helper\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class SelfClient {
	private Client $client;

	public function __construct() {
		$this->client = new Client( [
			"headers" => [
				"content-type" => "application/json",
				"Accept"       => "application/json"
			]
		] );
	}

	public function send_request( HttpRequest $backend_request ): HttpResponse {
		try {
			$backend_request->header( "Authorization", "Bearer " . ClientTokenManager::getToken() );

			$base_uri    = new Uri( get_site_url() . Endpoints::$HOOK . $backend_request->get_path() );
			$request_url = Uri::withQueryValues( $base_uri, $backend_request->get_params() );

			$request  = new Request( $backend_request->get_method(), $request_url, $backend_request->get_headers(), $backend_request->get_body() );
			$response = $this->client->send( $request );

			if ( $response->getStatusCode() != 200 ) {
				Logger::error( "Received non 200 status code (" . $response->getStatusCode() . ") for local request path: " . $request_url . " with request body: " . json_decode( $backend_request->get_body() ) );
			}

			return HttpResponse::backend_response()->body( json_decode( $response->getBody(), true ) )->status( $response->getStatusCode() );
		} catch ( GuzzleException $e ) {
			Logger::error( "Error happened when trying to execute backend request: " . $e->getMessage() );

			return HttpResponse::backend_response()->status( 500 );
		}
	}
}
