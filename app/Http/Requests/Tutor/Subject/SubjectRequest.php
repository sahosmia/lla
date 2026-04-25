<?php

namespace App\Http\Requests\Tutor\Subject;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id'                  => 'required|integer|gt:0',
            'subject_id'                => 'required|integer|gt:0',
            'hour_rate'                 =>  isPaidSystem() ? 'required|numeric|gt:0' : 'nullable',
            'description'               => 'required|string|min:10|max:65535',
            'image'                     => $this->imageRule(),
        ];
    }

    public function imageRule()
    {
        $file_ext  = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $file_size = (int) (setting('_general.max_image_size') ?? '3');
        return 'nullable|mimes:'.$file_ext.'|max:'.$file_size*1024;
    }

    public function messages(): array
    {
        $file_ext  = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $file_size = setting('_general.max_image_size') ?? '3';

        return [
            'required'      => __('validation.required_field'),
            'max'           => __('general.max_file_size_err',  ['file_size'    => $file_size.'MB']),
            'mimes'         => __('general.invalid_file_type',  ['file_types'   =>  allowFileExt($file_ext)])
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $data = [];

        $data['description']    = sanitizeTextField($this->description);

        $this->merge($data);
    }
}
