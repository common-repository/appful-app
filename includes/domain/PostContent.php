<?php

namespace AppfulPlugin\Domain;

class PostContent {
    private int $id = - 1;
    private string $head = "";
    private string $footer = "";
    private string $body_class = "";
    private string $content = "";

    private function __construct() {
    }

    public static function postContent(): PostContent {
        return new PostContent();
    }

    public function id( int $id ): PostContent {
        $this->id = $id;

        return $this;
    }

    public function head( string $head ): PostContent {
        $this->head = $head;

        return $this;
    }

    public function footer( string $footer ): PostContent {
        $this->footer = $footer;

        return $this;
    }

    public function content( string $content ): PostContent {
        $this->content = $content;

        return $this;
    }

    public function body_class( string $body_class ): PostContent {
        $this->body_class = $body_class;

        return $this;
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_head(): string {
        return $this->head;
    }

    public function get_footer(): string {
        return $this->footer;
    }

    public function get_content(): string {
        return $this->content;
    }

    public function get_body_class(): string {
        return $this->body_class;
    }
}
