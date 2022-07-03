<?php

namespace BlackCMS\Base\Enums;

use BlackCMS\Base\Supports\Enum;
use Html;

/**
 * @method static BaseStatusEnum DRAFT()
 * @method static BaseStatusEnum PUBLISHED()
 * @method static BaseStatusEnum PENDING()
 */
class BaseStatusEnum extends Enum
{
    public const PUBLISHED = "published";
    public const DRAFT = "draft";
    public const PENDING = "pending";

    /**
     * @var string
     */
    public static $langPath = "core/base::enums.statuses";

    /**
     * @return string
     */
    public function toHtml()
    {
        switch ($this->value) {
            case self::DRAFT:
                return Html::tag("span", self::DRAFT()->label(), [
                    "class" => "label-default status-label",
                ])->toHtml();
            case self::PENDING:
                return Html::tag("span", self::PENDING()->label(), [
                    "class" => "label-warning status-label",
                ])->toHtml();
            case self::PUBLISHED:
                return Html::tag("span", self::PUBLISHED()->label(), [
                    "class" => "label-primary status-label",
                ])->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
