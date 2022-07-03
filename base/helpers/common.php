<?php

use BlackCMS\Base\Facades\DashboardMenuFacade;
use BlackCMS\Base\Facades\PageTitleFacade;
use BlackCMS\Base\Supports\DashboardMenu;
use BlackCMS\Base\Supports\Editor;
use BlackCMS\Base\Supports\PageTitle;
use Illuminate\Support\Arr;

if (!function_exists("anchor_link")) {
    /**
     * @param string|null $link
     * @param string|null $name
     * @param array $options
     * @return string
     * @deprecated
     */
    function anchor_link(
        ?string $link,
        ?string $name,
        array $options = []
    ): string {
        return Html::link($link, $name, $options);
    }
}

if (!function_exists("language_flag")) {
    /**
     * @param string $flag
     * @param string|null $name
     * @return string
     */
    function language_flag(string $flag, ?string $name = null): string
    {
        return Html::image(
            asset(BASE_LANGUAGE_FLAG_PATH . $flag . ".svg"),
            $name,
            ["title" => $name, "width" => 16]
        );
    }
}

if (!function_exists("render_editor")) {
    /**
     * @param string $name
     * @param string|null $value
     * @param bool $withShortCode
     * @param array $attributes
     * @return string
     * @throws Throwable
     */
    function render_editor(
        string $name,
        ?string $value = null,
        bool $withShortCode = false,
        array $attributes = []
    ): string {
        return (new Editor())->render(
            $name,
            $value,
            $withShortCode,
            $attributes
        );
    }
}

if (!function_exists("is_in_admin")) {
    /**
     * @param bool $force
     * @return bool
     */
    function is_in_admin(bool $force = false): bool
    {
        $prefix = BaseHelper::getAdminPrefix();

        $segments = array_slice(
            request()->segments(),
            0,
            count(explode("/", $prefix))
        );

        $isInAdmin = implode("/", $segments) === $prefix;

        return $force
            ? $isInAdmin
            : apply_filters(IS_IN_ADMIN_FILTER, $isInAdmin);
    }
}

if (!function_exists("page_title")) {
    /**
     * @return PageTitle
     */
    function page_title(): PageTitle
    {
        return PageTitleFacade::getFacadeRoot();
    }
}

if (!function_exists("dashboard_menu")) {
    /**
     * @return DashboardMenu
     */
    function dashboard_menu(): DashboardMenu
    {
        return DashboardMenuFacade::getFacadeRoot();
    }
}

if (!function_exists("get_cms_version")) {
    /**
     * @return string
     */
    function get_cms_version(): string
    {
        $version = "1.0.0";

        try {
            $core = get_file_data(core_path("composer.json"));

            return Arr::get($core, "version", $version);
        } catch (Exception $exception) {
            return $version;
        }
    }
}

if (!function_exists("platform_path")) {
    /**
     * @param string|null $path
     * @return string
     */
    function platform_path(?string $path = null): string
    {
        return base_path("" . $path);
    }
}

if (!function_exists("core_path")) {
    /**
     * @param string|null $path
     * @return string
     */
    function core_path(?string $path = null): string
    {
        return platform_path("core/" . $path);
    }
}

if (!function_exists("package_path")) {
    /**
     * @param string|null $path
     * @return string
     */
    function package_path(?string $path = null): string
    {
        return platform_path("packages/" . $path);
    }
}
