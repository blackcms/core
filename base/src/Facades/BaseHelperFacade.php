<?php

namespace BlackCMS\Base\Facades;

use BlackCMS\Base\Helpers\BaseHelper;
use Illuminate\Support\Facades\Facade;

class BaseHelperFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BaseHelper::class;
    }
}
