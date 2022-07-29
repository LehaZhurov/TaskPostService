<?php

namespace App\Http\ApiV1\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class PatchPostRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'     => ['max:255','min:1','string'],
            'preview'   => ['url'],
        ];
    }
}
