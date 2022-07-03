<?php

namespace BlackCMS\ACL\Providers;

use BlackCMS\ACL\Repositories\Interfaces\UserInterface;
use BlackCMS\Dashboard\Supports\WidgetInstance as WidgetInstance;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter(
            DASHBOARD_FILTER_ADMIN_LIST,
            [$this, "addUserStatsWidget"],
            12,
            2
        );
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addUserStatsWidget($widgets, $widgetSettings)
    {
        $users = $this->app->make(UserInterface::class)->count();

        return (new WidgetInstance())
            ->setType("stats")
            ->setPermission("users.index")
            ->setTitle(trans("core/acl::users.users"))
            ->setKey("widget_total_users")
            ->setIcon("las la-users")
            ->setColor("#3598dc")
            ->setStatsTotal($users)
            ->setRoute(route("users.index"))
            ->init($widgets, $widgetSettings);
    }
}
