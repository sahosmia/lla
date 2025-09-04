<?php

namespace Modules\Quiz\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Carbon\Carbon;
use App\Rules\MinimumTimeFromNow;

class QuizSettingRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hours'                => ['required', 'numeric', 'min:0', 'max:23'],
            'minutes'              => ['required', 'numeric', 'min:0', 'max:59'],
            // 'attempts_allowed'     => 'required|numeric|min:1|max:5',
            'passing_grade'        => 'required|numeric|min:25|max:100',
            'question_order'       => 'required',
            'limit_short_answers'  => 'required|numeric|min:1|max:500',
            'limit_max_answers'    => 'required|numeric|min:1|max:5000',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'hours.required' => 'The hour field is required.',
            'hours.integer'  => 'The hour must be a valid number.',
            'hours.min'      => 'The hour must be between 0 and 23.',
            'hours.max'      => 'The hour must be between 0 and 23.',

            'minutes.required' => 'The minute field is required.',
            'minutes.integer'  => 'The minutes must be a valid number.',
            'minutes.min'      => 'The minutes must be between 0 and 59.',
            'minutes.max'      => 'The minutes must be between 0 and 59.',

            'attempts_allowed.required' => 'Please specify the number of allowed attempts.',
            'passing_grade.required'    => 'Please enter the passing grade.',
            'question_order.required'   => 'Question order is required.',
            'limit_short_answers.required' => 'Please specify the short answer limit.',
            'limit_max_answers.required'   => 'Please specify the max answer limit.',
        ];
    }
}
