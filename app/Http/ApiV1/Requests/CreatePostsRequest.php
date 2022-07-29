<?php

namespace App\Http\ApiV1\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;

class CreatePostsRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'     => ['required', 'max:255','min:1','string'],
            'preview'   => ['required', 'url'],
            'text'      => ['required'],
            'tags'      => ['array','nullable'],
            'tags.*'    => ['string'],
            'user_id'   => ['required', 'integer'],
        ];
    }
}
