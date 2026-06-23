<?php

namespace App\Livewire;

use App\Services\PayoutService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Payouts extends Component
{

    public $status    = '';
    public $isLoading = true;

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2' );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $payoutService = new PayoutService();
        $withdrawalDetails = $payoutService->getWithdrawalDetail(Auth::user()->id, $this->status);

        return view('livewire.pages.tutor.payouts',compact('withdrawalDetails'));
    }

    public function loadData()
    {
        $this->isLoading            = false;
        $this->dispatch('loadPageJs');
    }
}
