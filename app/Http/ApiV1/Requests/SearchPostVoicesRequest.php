<?php

namespace App\Http\ApiV1\Requests;

use App\Http\ApiV1\Support\Requests\BaseFormRequest;
use App\Http\ApiV1\Requests\SearchVoiceParams;

class SearchPostVoicesRequest extends BaseFormRequest implements SearchVoiceParams
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter' => ['array'],
            'filter.user_id' => ['integer', 'min:0'],
            'filter.post_id' => ['integer', 'min:0'],

            'include'   =>   ['array'],
            'include.*' =>   ['string'],

            'sort' => ['array'],
            'sort.*' => ['string'],
        ];
    }

    public function getFilter(): array
    {
        return $this->get('filter', []);
    }

    public function getSort(): array
    {
        return $this->get('sort', []);
    }

    public function isInclude(string $include): bool
    {
        return in_array($include, $this->get('include', ['default']));
    }
}
