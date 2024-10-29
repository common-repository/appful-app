<?php

namespace AppfulPlugin\Api\Dtos;

class BlogHooksDto {
    public ?string $create_comment;
    public ?string $authenticate_user;
    public ?string $get_page_content;

    public function __construct(
        ?string $create_comment,
        ?string $authenticate_user,
        ?string $get_page_content
    ) {
        $this->create_comment    = $create_comment;
        $this->authenticate_user = $authenticate_user;
        $this->get_page_content  = $get_page_content;
    }
}
