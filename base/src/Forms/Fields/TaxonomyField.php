<?php

namespace BlackCMS\Base\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class TaxonomyField extends FormField
{
    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addStylesDirectly(
            "vendor/core/core/base/libraries/tagify/tagify.css"
        )->addScriptsDirectly([
            "vendor/core/core/base/libraries/tagify/tagify.js",
            "vendor/core/core/base/js/taxonomies.js",
        ]);

        return "core/base::forms.fields.taxonomies";
    }
}
