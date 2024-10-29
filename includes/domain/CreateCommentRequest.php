<?php

namespace AppfulPlugin\Domain;

class CreateCommentRequest {
    private string $username;
    private string $email;
    private string $content;
    private int $post_id;
    private ?int $parent_id;

    public function __construct(
        string $username,
        string $email,
        string $content,
        int $post_id,
        ?int $parent_id
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->content = $content;
        $this->post_id = $post_id;
        $this->parent_id = $parent_id;
    }

    public function get_username(): string {
        return $this->username;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_content(): string {
        return $this->content;
    }

    public function get_parent_id(): ?int {
        return $this->parent_id;
    }

    public function get_post_id(): int {
        return $this->post_id;
    }
}
