<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CountryState;
use App\Models\User;
use App\Models\UserIdentityVerification;
use Carbon\Carbon;

class IdentityService {

    public $user;

    public function __construct($user) {
        if ($user instanceof User) {
            $this->user = $user;
        } else {
            $this->user = User::find($user);
        }
    }

    public function setUserIdentityVerification($identityInfo) {
        return  $this->user->identityVerification()->create($identityInfo);
    }

    public function deleteUserIdentityVerification(): void {
        $this->user->identityVerification()->delete();
    }


    public function getUserIdentityVerification(): UserIdentityVerification | NULL {
        return $this->user->identityVerification()->first();
    }

    public function updateParentVerification() {
        $this->user->identityVerification()->update(['parent_verified_at' => Carbon::now()]);
    }

    public function setUserAddress(string $id ,array $address): void {

        $this->getUserIdentityVerification()->address()->updateOrCreate(['addressable_id' => $id], $address);
    }

    public function deleteUserAddress(string $id): void {
        $this->getUserIdentityVerification()->address()->where('addressable_id', $id)->delete();
    }

    // public function countryStates($country)
    // {
    //     return CountryState::where('country_id', $country)->get(['name']);
    // }


    public function countryStates($country)
    {
        return CountryState::where('country_id', $country)->get(['id','name']);
    }

}
