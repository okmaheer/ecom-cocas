<?php

namespace Botble\Wrapping\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class WrappingRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required',
            'price' => 'required|numeric|max:10000',
            'status'  => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
