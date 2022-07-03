<?php

namespace BlackCMS\Base\Providers;

use BlackCMS\Base\Commands\ClearLogCommand;
use BlackCMS\Base\Commands\InstallCommand;
use BlackCMS\Base\Commands\PublishAssetsCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            ClearLogCommand::class,
            InstallCommand::class,
            PublishAssetsCommand::class,
        ]);
    }
}
