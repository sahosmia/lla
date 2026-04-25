<?php

namespace App\Livewire\Forms\Common\ProfileSettings;

use App\Traits\PrepareForValidation;
use App\Http\Requests\Common\Identity\IdentityStoreRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class IdentityVerificationForm extends Form
{
    use PrepareForValidation;

    public $lng;
    public $lat;
    public $user;
    public $image;
    public $identity;
    public $transcript;
    public string $city             = '';
    public string $name             = '';
    public string $state            = '';
    public $dateOfBirth;
    public string $country          = '';
    public string $zipcode          = '';
    public string $schoolId         = '';
    public string $parentName       = '';
    public string $schoolName       = '';
    public string $parentPhone      = '';
    public string $parentEmail      = '';
    public $identificationCard;
    public string $address          = '';
    public $enableGooglePlaces;
    public $countryName             = '';


    private ?IdentityStoreRequest $instructorRequest = null;

    public function boot()
    {
        $this->user                 = Auth::user();
        $this->instructorRequest    = new IdentityStoreRequest();
        $this->enableGooglePlaces   = setting('_api.enable_google_places') ?? '0';
    }

    public function rules(): array
    {

        return $this->instructorRequest->rules();
    }

    public function messages(): array
    {

        return $this->instructorRequest->messages();
    }

    public function updateInfo($hasState)
    {
        $rules = $this->rules();
        if ($hasState) {
            $rules['state']          = 'required|string';
        }
        $this->beforeValidation(['image', 'transcript', 'identificationCard']);
        $this->validate($rules);

        if (!empty($this->image)) {
            $imageName               = $this->image->getClientOriginalName();
            $personalPhoto           = $this->image->storeAs('identity_photo', $imageName, getStorageDisk());
        }

        if (!empty($this->identificationCard)) {
            $imageName               = $this->identificationCard->getClientOriginalName();
            $identificationCard      = $this->identificationCard->storeAs('identity_photo', $imageName, getStorageDisk());
        }

        if (!empty($this->transcript)) {
            $imageName               = $this->transcript->getClientOriginalName();
            $transcript              = $this->transcript->storeAs('identity_photo', $imageName, getStorageDisk());
        }

        try {
            $dob = \Carbon\Carbon::createFromFormat('F-d-Y', $this->dateOfBirth)->format('Y-m-d');
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            $dob = null;
        }

        $identityInfo = [
            'name'                   => $this->name,
            'personal_photo'         => !empty($this->image) ? $personalPhoto : null,
            'user_id'                => Auth::user()->id,
            'dob'                    => $dob,
            'attachments'            => $this->user->role == 'tutor' && !empty($this->identificationCard) ? $identificationCard : null,
            'school_id'              => $this->user->role == 'student' ? $this->schoolId    : null,
            'school_name'            => $this->user->role == 'student' ? $this->schoolName  : null,
            'transcript'             => $this->user->role == 'student' && !empty($this->transcript) ? $transcript : null,
            'parent_name'            => $this->user->role == 'student' ? $this->parentName  : null,
            'parent_email'           => $this->user->role == 'student' ? $this->parentEmail : null,
            'parent_phone'           => $this->user->role == 'student' ? $this->parentPhone : null,
        ];

        $address = [
            'country_id'             => !empty($this->country) ? $this->country : null,
            'state_id'               => !empty($this->state) ? $this->state : null,
            'city'                   => $this->city ?? null,
            'address'                => $this->address,
            'zipcode'                => $this->enableGooglePlaces != '1' ? $this->zipcode  : null,
            'lat'                    => $this->enableGooglePlaces == '1' ? $this->lat  : 0,
            'long'                   => $this->enableGooglePlaces == '1' ? $this->lng  : 0,
        ];

        return [
            'identityInfo'          => $identityInfo,
            'address'               => $address,
        ];
    }

    public function removePhoto()
    {
        $this->image = null;
    }

    public function removeIdentificationCard()
    {
        $this->identificationCard = null;
    }

    public function removeTranscript()
    {
        $this->transcript = null;
    }
}
