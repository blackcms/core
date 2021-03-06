<?php

namespace BlackCMS\ACL\Repositories\Caches;

use BlackCMS\ACL\Repositories\Interfaces\RoleInterface;
use BlackCMS\Support\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
