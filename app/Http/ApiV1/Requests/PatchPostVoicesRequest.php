<?php

namespace App\Http\ApiV1\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class PatchPostVoicesRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'voices'    => ['required', 'numeric', 'min:-1', 'max:1', Rule::notIn(['0'])],
            'user_id'   => ['required', 'numeric'],
        ];
    }
}
