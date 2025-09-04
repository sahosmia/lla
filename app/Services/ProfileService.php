<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CountryState;
use App\Models\Profile;
use App\Models\User;

class ProfileService
{

    public $user;

    public function __construct($userId = null)
    {
        if ($userId) {
            $this->user = User::find($userId);
        }
    }

    public function getUserProfile(): null|Profile
    {
        return $this->user->profile()->first();
    }

    public function getUserLanguages(): array | NULL
    {
        return $this->user->languages()->get()->pluck('id')->toArray();
    }

    public function setUserProfile(array $profileData): void
    {
        $this->user->profile()->updateOrCreate(['user_id' => $this->user->id], $profileData);
    }

    public function storeUserLanguages($userLanguages): void
    {
        if ($userLanguages) {
            $this->user->languages()->detach();
            $languages = array();
            foreach ($userLanguages as $langId) {
                $languages[] = [
                    'language_id' => $langId
                ];
            }
            $this->user->languages()->attach($languages);
        }
    }

    public function setUserAddress(array $address): void
    {
        $this->user->address()->updateOrCreate(['addressable_id' => $this->user->id], $address);
    }

    public function getSocialProfiles(): array
    {
        return $this->user->socialProfiles()->get()->toArray();
    }

    public function setSocialProfiles(array $socialProfiles): void
    {
        $this->user->socialProfiles()->delete();
        $this->user->socialProfiles()->createMany($socialProfiles);
    }

    public function getUserAddress()
    {
        return $this->user->address;
    }

    // public function countryStates($country)
    // {
    //     $country = Country::where('name', $country)->first();
    //     if($country){
    //         return $country->states()->get(['id','name']);
    //     }
    // }

    public function countryStates($country)
    {
        return CountryState::where('country_id', $country)->get(['id', 'name']);
    }
}
