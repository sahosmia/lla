<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursePriceRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price'         => 'required_if:isFree,false|nullable|numeric|min:0.01|max:99999.99',
            'discount'      => 'sometimes|numeric|min:0|max:100',
            'final_price'   => 'nullable|numeric|min:0|max:99999.99|lte:price',
        ];
    }

    public function messages()
    {
        return [
            'price.required_if' => 'The course price is required.',
        ];
    }

    /**
     * Map the request attributes to the course price attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'price'         => 'course price',
        ];
    }
}
