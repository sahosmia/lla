<?php

namespace Amentotech\LaraGuppy\Http\Requests;

class ProfileStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        
        return [
            'name'                => ['required', 'string', 'max:255'],
            'email'               => ['required', 'string', 'email', 'max:255'],
            'phone'               => ['sometimes', 'nullable', 'max:255'],
        ];
    }
}
