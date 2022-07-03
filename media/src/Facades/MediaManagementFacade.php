<?php

namespace BlackCMS\Media\Facades;

use BlackCMS\Media\MediaManagement;
use Illuminate\Support\Facades\Facade;

class MediaManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MediaManagement::class;
    }
}
