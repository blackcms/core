<?php

namespace BlackCMS\ACL\Http\Requests;

use BlackCMS\Support\Http\Requests\Request;
use MediaManagement;

class AvatarRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "avatar_file" => MediaManagement::imageValidationRule(),
            "avatar_data" => "required",
        ];
    }
}
