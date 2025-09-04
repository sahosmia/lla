<?php

namespace App\Livewire\Forms\Tutor\Experience;

use App\Http\Requests\Tutor\Experience\ExperienceStoreRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class UserExperienceForm extends Form
{

    use PrepareForValidation;
    public bool $is_current = false;
    public $title;
    public $employment_type;
    public $company;
    public $country;
    public $city;
    public $start_date;
    public $end_date;
    public $location;
    public $description;
    public $id;

    private ?ExperienceStoreRequest $request = null;

    public function boot() {
        $this->request = new ExperienceStoreRequest();
    }
    public function rules(){
        return $this->request->rules();
    }

    public function setExperience($experience = []){

        if(!empty($experience['id'])){
            $this->id               = $experience['id'] ?? '';
        }
        $this->title                = $experience['title'] ?? '';
        $this->employment_type      = $experience['employment_type'] ?? null;
        $this->location             = $experience['location'] ?? '';
        $this->company              = $experience['company'] ?? '';
        $this->country              = $experience['country_id'] ?? '';
        $this->city                 = $experience['city'] ?? '';
        $this->start_date           = $experience['start_date'] ?? '';
        $this->end_date             = $experience['end_date'] ?? null;
        $this->is_current           = $experience['is_current'] ?? false;
        $this->description          = $experience['description'] ?? '';
    }
    public function validateExperience(){
        $this->beforeValidation();
        $this->validate();
        $experience = [
            'id'                => $this->id,
            'title'             => $this->title,
            'employment_type'   => $this->employment_type,
            'company'           => $this->company,
            'location'          => $this->location,
            'country_id'        => $this->country,
            'city'              => $this->city,
            'start_date'        => $this->start_date,
            'end_date'          => !empty($this->end_date) ? $this->end_date : null,
            'is_current'        => $this->is_current,
            'description'       => $this->description,
        ];
        return $experience;
    }
}
