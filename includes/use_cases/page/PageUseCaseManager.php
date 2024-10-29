<?php

namespace AppfulPlugin\UseCases\Page;

use AppfulPlugin\Api\Client\SelfClient;

class PageUseCaseManager {
	private GetLocalPageContentByIdUseCase $get_local_page_content_by_id_use_case;
	private PullLocalPageContentUseCase $pull_local_page_content_use_case;
	private GetPageContentsByIdUseCase $get_page_contents_by_id_use_case;

	public function __construct( SelfClient $self_client ) {
		$this->get_local_page_content_by_id_use_case = new GetLocalPageContentByIdUseCase();
		$this->pull_local_page_content_use_case      = new PullLocalPageContentUseCase( $self_client );
		$this->get_page_contents_by_id_use_case      = new GetPageContentsByIdUseCase( $this->pull_local_page_content_use_case );
	}

	public function get_local_page_content_by_id_use_case(): GetLocalPageContentByIdUseCase {
		return $this->get_local_page_content_by_id_use_case;
	}

	public function pull_local_page_content_use_case(): PullLocalPageContentUseCase {
		return $this->pull_local_page_content_use_case;
	}

	public function get_page_contents_by_id_use_case(): GetPageContentsByIdUseCase {
		return $this->get_page_contents_by_id_use_case;
	}
}
