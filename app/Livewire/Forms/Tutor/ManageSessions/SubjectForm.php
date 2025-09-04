<?php

namespace App\Livewire\Forms\Tutor\ManageSessions;

use App\Http\Requests\Tutor\Subject\SubjectRequest;
use App\Traits\PrepareForValidation;
use Livewire\Form;

class SubjectForm extends Form
{
    use PrepareForValidation;
    public $edit_id = 0;
    public $group_id = '';
    public $subject_id = '';
    public $hour_rate = 0;
    public $description = '';
    public $sort_order = 0;
    public $image;
    public $preview_image;


    public function messages()
    {
        $request = new SubjectRequest();
        return $request->messages();
    }
    public function rules()
    {
        $request = new SubjectRequest();
        return $request->rules();
    }

    public function validateData()
    {
        $rules = $this->rules();
        if( empty($this->image) || !method_exists($this->image,'temporaryUrl')){
            unset($rules['image']);

        }
        $this->beforeValidation(['image']);
        return $this->validate($rules);

    }

    public function validateImage()
    {
        $request = new SubjectRequest();
        $rule = $request->imageRule();
        if (!is_string($this->image)) {
            $this->validate([
                'image' => $rule
            ]);
        }
    }

    public function addNewSubject($data)
    {

        $subject = [
            'user_subject_group_id' => $this->group_id,
            'subject_id' => $this->subject_id,
            'hour_rate' => $data['hour_rate'],
            'description' => $data['description'],
            'sort_order' => $this->sort_order,
            'image' => $this->image,
        ];

        if( !empty($this->image) && method_exists($this->image,'temporaryUrl')){
            $fileName = uniqueFileName('subjects', $this->image->getClientOriginalName());
            $url = $this->image->storeAs('subjects', $fileName, getStorageDisk());
            $subject['image'] = $url;
        }


        return $subject;
    }
}
