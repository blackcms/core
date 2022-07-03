<?php

namespace BlackCMS\Table\Http\Requests;

use BlackCMS\Support\Http\Requests\Request;

class FilterRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            "class" => "required",
        ];
    }
}
