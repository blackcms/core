<?php

namespace BlackCMS\Dashboard\Repositories\Caches;

use BlackCMS\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use BlackCMS\Support\Repositories\Caches\CacheAbstractDecorator;

class DashboardWidgetSettingCacheDecorator extends CacheAbstractDecorator implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getListWidget()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
