<?php

namespace App\Http\Requests\Common\AccountSetting;

use App\Http\Requests\BaseFormRequest;

class ZoomSettingStoreRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'zoom_account_id'               => 'required|string|max:100',
            'zoom_client_id'                => 'required|string|max:100',
            'zoom_client_secret'            => 'required|string|max:100'
        ];
    }
}
