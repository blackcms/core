<?php

namespace BlackCMS\Media\Repositories\Caches;

use BlackCMS\Media\Repositories\Interfaces\MediaSettingInterface;
use BlackCMS\Support\Repositories\Caches\CacheAbstractDecorator;

class MediaSettingCacheDecorator extends CacheAbstractDecorator implements
    MediaSettingInterface
{
}
