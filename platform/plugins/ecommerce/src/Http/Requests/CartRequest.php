<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Support\Http\Requests\Request;

class CartRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'  => 'required|min:1|integer',
            'qty' => 'min:1|integer',
            'productcolor' => 'sometimes|string',
            // 'image_direction' => 'sometimes|string'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => __('Product ID is required'),
            'id.integer'  => __('Product ID must be a number'),
            'productcolor.sometimes' => __('Product color is required'),
            'image_direction.sometimes' => __('Image Direction is required'),
            'productcolor.string' => __('Product color is required'),
            'image_direction.string' => __('Image Direction is required'),
        ];
    }
}
