<?php

namespace BlackCMS\Media\Models;

use BlackCMS\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MediaManagement;

class MediaFile extends BaseModel
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "media_files";

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ["created_at", "updated_at", "deleted_at"];

    /**
     * @var array
     */
    protected $fillable = [
        "name",
        "mime_type",
        "type",
        "size",
        "url",
        "options",
        "folder_id",
        "user_id",
    ];

    /**
     * @var array
     */
    protected $casts = [
        "options" => "json",
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (MediaFile $file) {
            if ($file->isForceDeleting()) {
                MediaManagement::deleteFile($file);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, "id", "folder_id");
    }

    /**
     * @return string
     */
    public function getTypeAttribute(): string
    {
        $type = "document";

        foreach (MediaManagement::getConfig("mime_types", []) as $key => $value) {
            if (in_array($this->attributes["mime_type"], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getHumanSizeAttribute(): string
    {
        return human_file_size($this->attributes["size"]);
    }

    /**
     * @return string
     */
    public function getIconAttribute(): string
    {
        switch ($this->type) {
            case "image":
                $icon = "las la-file-image la-2x";
                break;
            case "video":
                $icon = "las la-file-video la-2x";
                break;
            case "pdf":
                $icon = "las la-file-pdf la-2x";
                break;
            case "excel":
                $icon = "las la-file-excel la-2x";
                break;
            default:
                $icon = "las la-file-alt la-2x";
                break;
        }

        return $icon;
    }

    /**
     * @return bool
     */
    public function canGenerateThumbnails(): bool
    {
        return MediaManagement::canGenerateThumbnails($this->mime_type);
    }
}
