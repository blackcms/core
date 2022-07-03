<?php

namespace BlackCMS\Base\Supports;

use Illuminate\Support\Arr;

class Core
{
    /**
     * @var string
     */
    protected $currentVersion;

    /**
     * @var string
     */
    protected $oldVersion;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        $core = get_file_data(core_path("composer.json"));

        if ($core) {
            $this->currentVersion = Arr::get(
                $core,
                "version",
                $this->currentVersion
            );
        }
    }

    /**
     * @return string
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * @return string
     */
    public function getOldVersion()
    {
        return $this->oldVersion;
    }
}
