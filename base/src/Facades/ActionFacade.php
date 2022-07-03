<?php

namespace BlackCMS\Base\Facades;

use BlackCMS\Base\Supports\Action;
use Illuminate\Support\Facades\Facade;

class ActionFacade extends Facade
{
    /**
     * @return string
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return Action::class;
    }
}
