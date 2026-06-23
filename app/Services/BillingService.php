<?php

namespace App\Services;

use App\Models\CountryState;

class BillingService {


    public $user;

    public function __construct($user) {

        $this->user = $user;
    }

    public function getBillingDetail() {
        return $this->user->billingDetail()->first();
    }

    public function storeBillingDetail($billingDetail) {
        return  $this->user->billingDetail()->updateOrCreate(['user_id' => $this->user->id], $billingDetail);
    }

    public function getUserAddress()
    {
        $billingDetail = $this->getBillingDetail();
        return $billingDetail ? $billingDetail->address : null;
    }

    public function storeBillingAddress($id,$address): void {
        $this->user->billingDetail()->first()->address()->updateOrCreate(['addressable_id' =>  $id ?? null], $address);
    }

    public function countryStates($country)
    {
        return CountryState::where('country_id', $country)->get(['id','name']);
    }
}
