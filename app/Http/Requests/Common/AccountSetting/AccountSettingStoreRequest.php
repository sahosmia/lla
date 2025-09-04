<?php

namespace App\Http\Requests\Common\AccountSetting;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\BaseFormRequest;

class AccountSettingStoreRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($timezone = null): array
    {
        if($timezone){
            return $this->timezone();
        } else {
            return $this->password();
        }
    }

    public function timezone()
    {
        return [
            'timezone'          => !empty($timezone) ? 'required' : 'nullable'  
        ];
    }

    public function password()
    {
        return [
            'password'          => ['required',Password::defaults()] ,
            'confirm'           => ['required','same:password',Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
