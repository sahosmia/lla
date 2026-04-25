<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursePromotionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'promotion.code'                 => 'required|string|max:255',
            'promotion.valid_from'           => 'required|date',
            'promotion.valid_to'             => 'required|date|after_or_equal:promotion.valid_from',
            'promotion.discount_percentage'  => 'required|integer|min:1|max:100',
            'promotion.maximum_users'        => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'promotion.code'                 => 'promo code',
            'promotion.valid_from'           => 'start date',
            'promotion.valid_to'             => 'end date',
            'promotion.discount_percentage'  => 'discount percentage',
            'promotion.maximum_users'        => 'users per promotion',
        ];
    }

    /**
     * Prepare the data for validation.
     * @return void
     */

    // protected function prepareForValidation() {
    //     $this->merge([]);
    // }
}
