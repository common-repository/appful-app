<?php

namespace AppfulPlugin\Helper;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TemplateLoader {
	private FilesystemLoader $loader;

	public function __construct() {
		$this->loader = new FilesystemLoader( plugin_dir_path( __FILE__ ) . "./../../frontend/templates/" );
	}

	public function load_template( string $template, array $data ): string {
		$twig = new Environment( $this->loader );
		try {
			return $twig->render( $template, $data );
		} catch ( LoaderError|RuntimeError|SyntaxError $e ) {
			return "";
		}
	}

}