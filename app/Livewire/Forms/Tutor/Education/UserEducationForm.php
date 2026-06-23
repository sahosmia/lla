<?php

namespace App\Livewire\Forms\Tutor\Education;

use App\Http\Requests\Tutor\Education\EducationStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class UserEducationForm extends Form
{
    use PrepareForValidation;
    public bool $ongoing = false;
    public $institute_name;
    public $course_title;
    public $description;
    public $start_date;
    public $end_date;
    public $country;
    public $city;
    public $id;

    public function rules(){
        $request = new EducationStoreRequest();
        return $request->rules();
    }

    public function messages(){
        $request = new EducationStoreRequest();
        return $request->messages();
    }

    public function setEducation($education = []){
        if(!empty($education['id'])){
            $this->id               = $education['id'] ?? '';
        }

        $this->course_title         = $education['course_title'] ?? '';
        $this->institute_name       = $education['institute_name'] ?? '';
        $this->country              = $education['country_id'] ?? '';
        $this->city                 = $education['city'] ?? '';
        $this->start_date           = $education['start_date'] ?? '';
        $this->end_date             = $education['end_date'] ?? null;
        $this->ongoing              = $education['ongoing'] ?? false;
        $this->description          = $education['description'] ?? '';
    }

    public function validateEducation(){
        $this->beforeValidation();
        $this->validate($this->rules(), $this->messages());
        $education = [
            'id'                    => $this->id,
            'course_title'          => $this->course_title,
            'institute_name'        => $this->institute_name,
            'country_id'            => $this->country,
            'city'                  => $this->city,
            'start_date'            => $this->start_date,
            'end_date'              => $this->ongoing ? null : $this->end_date,
            'ongoing'               => $this->ongoing,
            'description'           => $this->description,
        ];
        return $education;
    }
}
