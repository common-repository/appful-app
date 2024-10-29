<?php

namespace AppfulPlugin\Domain;

class BlogInfo {
    private string $hostname = "";
    private string $site_url = "";
    private array $languages = [];
    private string $token = "";
    private ?BlogHooks $hooks = null;
    private ?BlogStats $stats = null;
    private ?BlogSettings $settings = null;

    private function __construct() {
    }

    public static function blog_info(): BlogInfo {
        return new BlogInfo();
    }

    public function languages( array $languages ): BlogInfo {
        $this->languages = $languages;

        return $this;
    }

    public function settings( ?BlogSettings $settings ): BlogInfo {
        $this->settings = $settings;

        return $this;
    }

    public function site_url( string $site_url ): BlogInfo {
        $this->site_url = $site_url;

        return $this;
    }

    public function hostname( string $hostname ): BlogInfo {
        $this->hostname = $hostname;

        return $this;
    }

    public function token( string $token ): BlogInfo {
        $this->token = $token;

        return $this;
    }

    public function hooks( ?BlogHooks $hooks ): BlogInfo {
        $this->hooks = $hooks;

        return $this;
    }

    public function stats( ?BlogStats $stats ): BlogInfo {
        $this->stats = $stats;

        return $this;
    }

    public function get_site_url(): string {
        return $this->site_url;
    }

    public function get_languages(): array {
        return $this->languages;
    }

    public function get_hostname(): string {
        return $this->hostname;
    }

    public function get_token(): string {
        return $this->token;
    }

    public function get_hooks(): ?BlogHooks {
        return $this->hooks;
    }

    public function get_stats(): ?BlogStats {
        return $this->stats;
    }

    public function get_settings(): ?BlogSettings {
        return $this->settings;
    }
}