<?php

namespace BlackCMS\Media\Models;

use BlackCMS\Base\Models\BaseModel;

class MediaSetting extends BaseModel
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = "media_settings";

    /**
     * @var array
     */
    protected $fillable = ["key", "value", "user_id"];

    /**
     * @var array
     */
    protected $casts = [
        "value" => "json",
    ];
}
