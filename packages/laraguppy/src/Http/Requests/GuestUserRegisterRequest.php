<?php

namespace Amentotech\LaraGuppy\Http\Requests;

class GuestUserRegisterRequest extends BaseFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }
}
