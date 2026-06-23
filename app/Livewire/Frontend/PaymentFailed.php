<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class PaymentFailed extends Component
{
    public function render()
    {
        return view('livewire.frontend.payment-failed')
            ->extends('layouts.frontend-app', [
                'pageTitle' => __('payment.payment_failed_page'),
            ]);
    }
}
