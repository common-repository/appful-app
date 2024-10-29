<?php

namespace AppfulPlugin\Main;

use AppfulPlugin\Api\Api;
use AppfulPlugin\Api\Client\BackendClient;
use AppfulPlugin\Api\Client\SelfClient;
use AppfulPlugin\Api\ReqHandler;
use AppfulPlugin\Api\Rewrites;
use AppfulPlugin\CustomTaxonomies\TaxonomyManager;
use AppfulPlugin\Hooks\Hooks;
use AppfulPlugin\Menu\Menu;
use AppfulPlugin\Notice\Notice;
use AppfulPlugin\PostForm\PostForm;
use AppfulPlugin\TermForm\TermForm;
use AppfulPlugin\UseCases\UseCaseManager;

class AppfulPlugin {

	private Menu $menu;
	private TermForm $term_form;
	private PostForm $post_form;
	private Notice $notice;
	private Hooks $hooks;
	private Api $api;
	private UseCaseManager $use_case_manager;
	private TaxonomyManager $taxonomy_manager;

	public function __construct() {
		$rewrites               = new Rewrites();
		$backend_client         = new BackendClient();
		$self_client            = new SelfClient();
		$this->use_case_manager = new UseCaseManager( $backend_client, $self_client );
		$api_request_handler    = new ReqHandler( $this->use_case_manager );

		$this->taxonomy_manager = new TaxonomyManager();

		$this->menu      = new Menu( $this->use_case_manager->is_logged_in_use_case() );
		$this->term_form = new TermForm();
		$this->post_form = new PostForm();
		$this->notice    = new Notice( $this->use_case_manager->is_logged_in_use_case() );
		$this->hooks     = new Hooks( $rewrites, $this->use_case_manager, $this->taxonomy_manager );
		$this->api       = new Api( $api_request_handler );
	}

	public function init() {
		$this->configure_instance();

        $this->menu->register();
        $this->notice->register();

        $this->hooks->init();
		$this->api->init();

		if ( $this->use_case_manager->is_logged_in_use_case()->invoke() ) {
			$this->term_form->load();
			$this->post_form->load();
			$this->taxonomy_manager->load();
		}
	}

	private function configure_instance() {
		ini_set( "allow_url_fopen", 1 );
	}

}