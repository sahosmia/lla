<?php

namespace App\Http\Requests\Tutor\Payout;

use App\Http\Requests\BaseFormRequest;

class PaymentRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_method'             => 'required|string',
        ];
    }

}
