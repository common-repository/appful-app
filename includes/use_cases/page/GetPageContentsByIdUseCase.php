<?php

namespace AppfulPlugin\UseCases\Page;

use AppfulPlugin\Domain\PageContent;

class GetPageContentsByIdUseCase {
    private PullLocalPageContentUseCase $pull_local_page_content_use_case;

    public function __construct( PullLocalPageContentUseCase $pull_local_page_content_use_case ) {
        $this->pull_local_page_content_use_case = $pull_local_page_content_use_case;
    }

    /**
     * @param int[] $ids
     *
     * @return PageContent[]
     */
    public function invoke( array $ids, ?int $user_id = null ): array {
        $page_contents = [];

        foreach ($ids as $page_id) {
            $response = $this->pull_local_page_content_use_case->invoke( $page_id, $user_id );
            if ( $response != null ) {
                $page_contents[] = $response;
            }
        }

        return $page_contents;
    }
}
