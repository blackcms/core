<?php

namespace BlackCMS\Dashboard\Providers;

use BlackCMS\Base\Traits\LoadAndPublishDataTrait;
use BlackCMS\Dashboard\Models\DashboardWidget;
use BlackCMS\Dashboard\Models\DashboardWidgetSetting;
use BlackCMS\Dashboard\Repositories\Caches\DashboardWidgetCacheDecorator;
use BlackCMS\Dashboard\Repositories\Caches\DashboardWidgetSettingCacheDecorator;
use BlackCMS\Dashboard\Repositories\Eloquent\DashboardWidgetRepository;
use BlackCMS\Dashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use BlackCMS\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use BlackCMS\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * @since 02/07/2016 09:50 AM
 */
class DashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetCacheDecorator(
                new DashboardWidgetRepository(new DashboardWidget())
            );
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingCacheDecorator(
                new DashboardWidgetSettingRepository(
                    new DashboardWidgetSetting()
                )
            );
        });
    }

    public function boot()
    {
        $this->setNamespace("core/dashboard")
            ->loadHelpers()
            ->loadRoutes(["web"])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadMigrations();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                "id" => "cms-core-dashboard",
                "priority" => 0,
                "parent_id" => null,
                "name" => "core/base::layouts.dashboard",
                "icon" => "las la-home la-2x",
                "url" => route("dashboard.index"),
                "permissions" => [],
            ]);
        });
    }
}
