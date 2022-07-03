<?php

namespace BlackCMS\Dashboard\Repositories\Caches;

use BlackCMS\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use BlackCMS\Support\Repositories\Caches\CacheAbstractDecorator;

class DashboardWidgetCacheDecorator extends CacheAbstractDecorator implements
    DashboardWidgetInterface
{
}
