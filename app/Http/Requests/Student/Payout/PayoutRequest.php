<?php

namespace App\Http\Requests\Student\Payout;

use App\Http\Requests\BaseFormRequest;

class PayoutRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules($current_method = null)
    {

        if(empty($current_method)){
            $current_method = $this->current_method;
        }

        if($current_method != 'bank'){
            return [
                'email'             => 'required|email',
            ];
        }

        return [
            'title'             => 'required|string|max:255',
            'accountNumber'     => 'required|numeric|digits_between:8,20',
            'bankName'          => 'required|string|max:255',
            'bankRoutingNumber' => 'nullable|numeric|digits:9',
            'bankIban'          => 'nullable|string',
            'bankBtc'           => 'nullable|string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'title'                     => sanitizeTextField($this->title),
            'accountNumber'             => sanitizeTextField($this->accountNumber),
            'bankName'                  => sanitizeTextField($this->bankName),
            'bankRoutingNumber'         => sanitizeTextField($this->bankRoutingNumber),
            'bankIban'                  => sanitizeTextField($this->bankIban),
            'bankBtc'                   => sanitizeTextField($this->bankBtc),
        ]);
    }
}
