<?php

namespace BlackCMS\Base\Facades;

use BlackCMS\Base\Supports\DashboardMenu;
use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DashboardMenu::class;
    }
}
