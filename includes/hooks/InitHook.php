<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Api\Rewrites;

class InitHook {
	private Rewrites $appful_rewrites;

	public function __construct( Rewrites $appful_rewrites ) {
		$this->appful_rewrites = $appful_rewrites;
	}

	public function init() {
		add_action(
			"init",
			function () {
				$this->on_init();
			},
			9,
			0
		);
	}

	private function on_init() {
		$this->appful_rewrites->enable_rewrite();
		// WordPress did load resources
		$this->appful_rewrites->enable_custom_vars();
	}
}