<?php

namespace App\Http\Requests\Tutor\Certificate;

use App\Http\Requests\BaseFormRequest;

class CertificateStoreRequest extends BaseFormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image'              => $this->imageRule(),
            'title'              => 'required|string|max:255',
            'institute_name'     => 'required|string|max:255',
            'issue_date'         => 'required|date',
            'expiry_date'        => 'required|date|after:start_date',
            'description'        => 'required|string|max:65535',
        ];
    }

    public function imageRule() {
        $file_ext  = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $file_size = (int) (setting('_general.max_image_size') ?? '3');
        return 'required|mimes:'.$file_ext.'|max:'.$file_size*1024;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void {
        $this->merge([
            'title'                     => sanitizeTextField($this->title),
            'institute_name'            => sanitizeTextField($this->institute_name),
            'description'               => sanitizeTextField($this->description, keep_linebreak: true),
        ]);
    }

}

    // public function messages()
    // {
    //     return [
    //         'required'                   => __('general.required_field'),
    //         'end_date.required_if'       => __('calendar.date_range_error'),
    //         'end_date.after'             => __('calendar.date_range_error'),
    //     ];
    // }

