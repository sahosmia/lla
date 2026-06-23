<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class PaymentCancelled extends Component
{
    public function render()
    {
        return view('livewire.frontend.payment-cancelled')
            ->extends('layouts.frontend-app', [
                'pageTitle' => __('payment.payment_cancelled_page'),
            ]);
    }
}
