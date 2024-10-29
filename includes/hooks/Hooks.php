<?php

namespace AppfulPlugin\Hooks;

use AppfulPlugin\Api\Rewrites;
use AppfulPlugin\CustomTaxonomies\TaxonomyManager;
use AppfulPlugin\UseCases\UseCaseManager;

class Hooks {

	private ActivationHook $appful_activation_hook;
	private PostHook $appful_post_hook;
	private PageHook $appful_page_hook;
	private CommentHook $appful_comment_hook;
	private SessionHook $appful_session_hook;
	private TaxonomyHook $taxonomy_hook;
	private AttachmentHook $attachment_hook;
	private UserHook $user_hook;
	private InitHook $init_hook;
	private AppSettingsHook $app_settings_hook;

	private UseCaseManager $use_case_manager;

	public function __construct( Rewrites $appful_rewrites, UseCaseManager $use_case_manager, TaxonomyManager $taxonomy_manager ) {
		$this->use_case_manager       = $use_case_manager;
		$this->appful_activation_hook = new ActivationHook( $appful_rewrites, $use_case_manager, $taxonomy_manager );
		$this->appful_session_hook    = new SessionHook( $use_case_manager );
		$this->appful_post_hook       = new PostHook( $use_case_manager );
		$this->appful_page_hook       = new PageHook( $use_case_manager );
		$this->appful_comment_hook    = new CommentHook( $use_case_manager );
		$this->taxonomy_hook          = new TaxonomyHook( $use_case_manager );
		$this->attachment_hook        = new AttachmentHook( $use_case_manager );
		$this->user_hook              = new UserHook( $use_case_manager );
		$this->init_hook              = new InitHook( $appful_rewrites );
		$this->app_settings_hook      = new AppSettingsHook( $use_case_manager );
	}

	public function init() {
		$this->init_hook->init();
		$this->appful_activation_hook->init();
		$this->appful_session_hook->init();

		if ( $this->use_case_manager->is_logged_in_use_case()->invoke() ) {
			$this->appful_post_hook->init();
			$this->appful_page_hook->init();
			$this->taxonomy_hook->init();
			$this->appful_comment_hook->init();
			$this->attachment_hook->init();
			$this->user_hook->init();
			$this->app_settings_hook->init();
		}
	}
}
