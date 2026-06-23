<?php

namespace App\Http\Requests\Tutor\Experience;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ExperienceStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title'                     => 'required|string|max:255',
            'employment_type'           => 'required|string|in:full_time,part_time,contract,self_employed',
            'company'                   => 'required|string|max:255',
            'location'                  => 'required|string|in:onsite,remote,hybrid',
            'country'                   => 'required|numeric',
            'city'                      => 'required|string|max:255',
            'start_date'                => 'required|date',
            'end_date'                  => 'required_if:is_current,false|nullable|date|after:start_date',
            'is_current'                => 'boolean',
            'description'               => 'required|string|min:10',
        ];
    }

    protected function prepareForValidation(): void {
        $this->merge([
            'title'                     => sanitizeTextField($this->title),
            'company'                   => sanitizeTextField($this->company),
            'city'                      => sanitizeTextField($this->city),
            'description'               => sanitizeTextField($this->description, keep_linebreak: true),
        ]);
    }

}
