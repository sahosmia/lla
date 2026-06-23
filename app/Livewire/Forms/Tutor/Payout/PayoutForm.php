<?php

namespace App\Livewire\Forms\Tutor\Payout;
use App\Http\Requests\Student\Payout\PayoutRequest;
use App\Traits\PrepareForValidation;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class PayoutForm extends Form
{
    use PrepareForValidation;
    public $title;
    public $user;
    public $email;
    public $bankBtc;
    public $bankName;
    public $bankIban;
    public $accountNumber;
    public $current_method;
    public $bankRoutingNumber;
    private ?PayoutRequest $request = null;

    public function boot()
    {
        $this->user         = Auth::user();
        $this->request      = new PayoutRequest();
    }

    public function rules()
    {

        return $this->request->rules($this->current_method);
    }

    public function validatePayout()
    {
        $this->beforeValidation();
        $this->validate();
        $payout = [
            'user_id'           => $this->user->id,
            'status'            => 'active',
            'payout_method'     => $this->current_method,
            'deleted_at'        => null,
            'payout_details'    => $this->current_method != 'bank' ?  [['email'=> $this->email]] : [
                'title'                 => $this->title,
                'account_number'        => $this->accountNumber,
                'bank_name'             => $this->bankName,
                'bank_routing_number'   => $this->bankRoutingNumber,
                'bank_iban'             => $this->bankIban,
                'bank_btc'              => $this->bankBtc,
            ],

        ];
        return $payout;
    }
}

