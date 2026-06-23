<?php

namespace App\Http\Requests\Common\CartRequest;

use App\Http\Requests\BaseFormRequest;

class CartRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id'                => 'required',
            'slot_id'           => 'required',
            'tutor_id'          => 'required',
            'tutor_name'        => 'required|string|max:255',
            'session_time'      => 'required|string',
            'subject_group'     => 'required|string|max:255',
            'subject'           => 'required|string|max:255',
            'image'             => 'required|string',
            'currency_symbol'   => 'required|string|max:3',
            'price'             => 'required',
        ];
    }
}
    
