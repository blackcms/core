<?php

namespace BlackCMS\Base\Providers;

use BlackCMS\Base\Events\BeforeEditContentEvent;
use BlackCMS\Base\Events\CreatedContentEvent;
use BlackCMS\Base\Events\DeletedContentEvent;
use BlackCMS\Base\Events\SendMailEvent;
use BlackCMS\Base\Events\UpdatedContentEvent;
use BlackCMS\Base\Listeners\BeforeEditContentListener;
use BlackCMS\Base\Listeners\CreatedContentListener;
use BlackCMS\Base\Listeners\DeletedContentListener;
use BlackCMS\Base\Listeners\SendMailListener;
use BlackCMS\Base\Listeners\UpdatedContentListener;
use Illuminate\Support\Facades\Event;
use File;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SendMailEvent::class => [SendMailListener::class],
        CreatedContentEvent::class => [CreatedContentListener::class],
        UpdatedContentEvent::class => [UpdatedContentListener::class],
        DeletedContentEvent::class => [DeletedContentListener::class],
        BeforeEditContentEvent::class => [BeforeEditContentListener::class],
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(["cache:cleared"], function () {
            File::delete([
                storage_path("cache_keys.json"),
                storage_path("settings.json"),
            ]);
        });
    }
}
