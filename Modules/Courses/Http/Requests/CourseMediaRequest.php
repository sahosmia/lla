<?php

namespace Modules\Courses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMediaRequest extends FormRequest
{

    protected $imageExtensions, $videoExtensions, $imageSize, $videoSize;

    public function __construct()
    {
        $this->imageExtensions          = setting('_general.allowed_image_extensions') ?? 'jpg,png,jpeg';
        $this->videoExtensions          = setting('_general.allowed_video_extensions') ?? 'mp4,mov,avi,mkv,wmv,flv,webm';
        $this->imageSize                = setting('_general.max_image_size') * 1024 ?? 5;
        $this->videoSize                = setting('_general.max_video_size') * 1024 ?? 20;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'thumbnail'         => 'required|string',
            'promotionalVideo'  => 'required|mimes:' . $this->videoExtensions . '|max:' . $this->videoSize,
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($this->isBase64) && isset($this->thumbnail) && $this->isBase64 && $this->thumbnail) {
                $validator->addRules([
                    'thumbnail' => 'required|regex:/^data:image\/[a-zA-Z]+;base64,/|string',
                ]);
            }

            if (isset($this->coursePromotionalVideo) || isset($this->promotionalVideo)) {
                $validator->addRules([
                    'promotionalVideo' => 'nullable|mimes:' . $this->videoExtensions . '|max:' . $this->videoSize,
                ]);
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'promotionalVideo'              => 'promotional video',
            'thumbnail'                     => 'course thumbnail',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'promotionalVideo.max'         => __('courses::courses.promotional_video_max', ['max' => round($this->videoSize / 100)]),
        ];
    }
}
