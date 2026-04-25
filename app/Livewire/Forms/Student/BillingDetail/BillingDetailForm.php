<?php

namespace App\Livewire\Forms\Student\BillingDetail;

use App\Http\Requests\Student\BillingDetail\BillingDetailStoreRequest;
use App\Traits\PrepareForValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BillingDetailForm extends Form
{
    use PrepareForValidation;
    public $lng ;
    public $lat ;
    public $user ;
    public string $city             = '';
    public string $firstName        = '';
    public string $lastName         = '';
    public string $company          = '';
    public string $email            = '';
    public string $phone            = '';
    public string $state            = '';
    public string $address          = '';
    public string $country          = '';
    public string $zipcode          = '';
    public $enableGooglePlaces;
    public $countryName;




    private ?BillingDetailStoreRequest $billingRequest = null;

    public function boot()
    {
        $this->user                 = Auth::user();
        $this->billingRequest       = new BillingDetailStoreRequest();
        $this->enableGooglePlaces   = setting('_api.enable_google_places') ?? '0';
    }

    public function rules(): array
    {

        return $this->billingRequest->rules();
    }

    public function messages(): array
    {

            return $this->billingRequest->messages();
    }

    public function getInfo($billigDetail)
    {
        $this->firstName    = $billigDetail?->first_name ?? '';
        $this->lastName     = $billigDetail?->last_name ?? '';
        $this->company      = $billigDetail?->company ?? '';
        $this->email        = $billigDetail?->email ?? '';
        $this->phone        = $billigDetail?->phone ?? '';
    }

    public function setUserAddress($address)
    {
        $this->country = $address?->country_id ?? '';
        $this->city = $address?->city ?? '';
        $this->zipcode = $address?->zipcode ?? '';
        $this->state = $address?->state_id ?? '';
        $this->address = $address?->address ?? '';
        $this->lat = $address?->lat ?? '';
        $this->lng = $address?->long ?? '';
    }


    public function updateInfo($hasState)
    {
        $rules = $this->rules();
        if($hasState){
            $rules['state'] = 'required|string';
        }
        $this->beforeValidation();
        $this->validate($rules, $this->messages());

        $billingDetail = [
            'first_name'                => $this->firstName,
            'last_name'                 => $this->lastName,
            'user_id'                   => Auth::user()->id,
            'company'                   => $this->company,
            'email'                     => $this->email,
            'phone'                     => $this->phone,

        ];

        $address = [
            'country_id'             => $this->enableGooglePlaces != '1' ? $this->country  : null,
            'state_id'               => !empty($this->state) ? $this->state : null,
            'city'                   => $this->enableGooglePlaces != '1' ? $this->city  : null,
            'address'                => !empty($this->address) ? $this->address : null,
            'zipcode'                => $this->enableGooglePlaces != '1' ? $this->zipcode  : null,
            'lat'                    => $this->enableGooglePlaces == '1' ? $this->lat  : 0,
            'long'                   => $this->enableGooglePlaces == '1' ? $this->lng  : 0,
        ];

        return [
            'billingDetail'  => $billingDetail,
            'address'       => $address,
        ];

    }


}
