<?php

namespace BlackCMS\ACL\Providers;

use BlackCMS\ACL\Events\RoleAssignmentEvent;
use BlackCMS\ACL\Events\RoleUpdateEvent;
use BlackCMS\ACL\Listeners\LoginListener;
use BlackCMS\ACL\Listeners\RoleAssignmentListener;
use BlackCMS\ACL\Listeners\RoleUpdateListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RoleUpdateEvent::class => [RoleUpdateListener::class],
        RoleAssignmentEvent::class => [RoleAssignmentListener::class],
        Login::class => [LoginListener::class],
    ];
}
