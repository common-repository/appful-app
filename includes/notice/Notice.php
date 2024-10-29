<?php

namespace AppfulPlugin\Notice;

use AppfulPlugin\Helper\TemplateLoader;
use AppfulPlugin\UseCases\IsLoggedInUseCase;

class Notice {
    private IsLoggedInUseCase $is_logged_in_use_case;

    public function __construct( IsLoggedInUseCase $is_logged_in_use_case ) {
        $this->is_logged_in_use_case = $is_logged_in_use_case;
    }

    public function register(): void {
        if ( !$this->is_appful_menu_page() && !$this->is_logged_in_use_case->invoke() ) {
            add_action(
                "admin_notices",
                function () {
                    $this->register_notice();
                },
                10,
                0
            );
        }
    }

    private function is_appful_menu_page(): bool {
        global $pagenow;
        return $pagenow === "admin.php" && isset( $_GET["page"] ) && $_GET["page"] === "appful_menu";
    }

    private function register_notice(): void {
        $template_loader = new TemplateLoader();
        echo($template_loader->load_template(
            "appful_notice.html.twig",
            [
                "appful_page_link" => $this->build_url()
            ]
        ));
    }

    private function build_url(): string {
        return esc_url(
            add_query_arg(
                "page",
                "appful_menu",
                get_admin_url() . "admin.php"
            )
        );
    }
}
