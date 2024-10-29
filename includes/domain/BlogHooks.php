<?php

namespace AppfulPlugin\Domain;

class BlogHooks {
    private ?string $create_comment = null;
    private ?string $authenticate_user = null;
    private ?string $get_page_content = null;

    private function __construct() {
    }

    public static function init(): BlogHooks {
        return new BlogHooks();
    }

    public function create_comment( ?string $create_comment ): BlogHooks {
        $this->create_comment = $create_comment;

        return $this;
    }

    public function authenticate_user( ?string $authenticate_user ): BlogHooks {
        $this->authenticate_user = $authenticate_user;

        return $this;
    }

    public function get_page_content( ?string $get_page_content ): BlogHooks {
        $this->get_page_content = $get_page_content;

        return $this;
    }

    public function get_create_comment(): ?string {
        return $this->create_comment;
    }

    public function get_authenticate_user(): ?string {
        return $this->authenticate_user;
    }

    public function get_get_page_content(): ?string {
        return $this->get_page_content;
    }
}
