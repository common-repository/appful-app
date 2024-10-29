<?php

namespace AppfulPlugin\Api\Dtos;

class BlogInfoDto {
    public string $hostname;
    public string $site_url;
    public array $languages;
    public string $token;
    public ?BlogHooksDto $hooks;
    public string $version;
    public ?BlogStatsDto $stats;
    public ?BlogSettingsDto $settings;

    public function __construct( string $hostname, string $site_url, array $languages, string $token, ?BlogHooksDto $hooks, string $version, ?BlogStatsDto $stats, ?BlogSettingsDto $settings ) {
        $this->hostname  = $hostname;
        $this->site_url  = $site_url;
        $this->languages = $languages;
        $this->token     = $token;
        $this->hooks     = $hooks;
        $this->version   = $version;
        $this->stats     = $stats;
        $this->settings  = $settings;
    }
}
