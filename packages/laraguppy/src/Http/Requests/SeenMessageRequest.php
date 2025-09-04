<?php

namespace Amentotech\LaraGuppy\Http\Requests;

use Amentotech\LaraGuppy\Http\Requests\BaseFormRequest;

class SeenMessageRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'message_id'        => 'required|integer|max:9999999',
            'thread_id'         => 'required|integer|max:9999999'    
        ];
    }
}
