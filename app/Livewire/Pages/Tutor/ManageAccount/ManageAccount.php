<?php
namespace App\Livewire\Pages\Tutor\ManageAccount;

use App\Livewire\Forms\Tutor\Payout\PayoutForm;
use App\Services\PayoutService;
use App\Services\WalletService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ManageAccount extends Component
{
    use WithPagination;

    public $data      = [];
    public $status    = '';
    public $isLoading = true;
    public $earnedAmount, $pendingFunds;
    public $chart = false;
    public $payoutStatus;
    public $selectedDate;
    public $walletBalance;
    public $withdrawalsType;
    public $withdrawalBalance;

    public  PayoutForm $form;
    private ?WalletService $walletService   = null;
    private ?PayoutService $payoutService   = null;

    public function boot()
    {
        $this->walletService   = new WalletService();
        $this->payoutService   = new PayoutService();
    }

    public function mount()
    {
        $this->chart = true;
        $this->selectedDate         = now(getUserTimezone());
        $this->data                 = $this->walletService->getUserEarnings(Auth::user()->id, $this->selectedDate);
        $this->earnedAmount         = $this->walletService->getEarnedIncome(Auth::user()->id);
        $this->pendingFunds         = $this->walletService->getPendingAvailableFunds(Auth::user()->id);
        $this->dispatch('initSelect2', target: '.am-select2' );
    }

    #[On('refresh-payouts')]
    public function refresh(){
        $this->loadData();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $withdrawalDetails          = $this->payoutService->getWithdrawalDetail(Auth::user()->id,$this->status);
        return view('livewire.pages.tutor.manage-account.manage-account',compact('withdrawalDetails'));
    }

    public function loadData()
    {
        $this->isLoading      = true;
        if($this->chart){

            $this->dispatch('initChartJs', currentDate: parseToUserTz($this->selectedDate->copy())->format('F, Y'), data: $this->data);
        }
        $this->chart = false;
        $this->walletBalance        = $this->walletService->getWalletAmount(Auth::user()->id);
        $this->withdrawalBalance    = $this->payoutService->geWithdrawalBalance(Auth::user()->id)->toArray();
        $this->withdrawalsType      = $this->payoutService->getWithdrawalTypes(Auth::user()->id);
        $this->payoutStatus         = $this->payoutService->getPayoutStatus(Auth::user()->id);
        $this->dispatch('initSelect2', target: '.am-select2' );
        $this->isLoading            = false;
    }

    public function updatedSelectedDate($date)
    {
        $date               = $date instanceof Carbon ? $date->format('F, Y') : $date;
        $this->selectedDate = Carbon::createFromFormat('d F, Y', "01 $date");
        $this->loadData();
    }

    public function updatePayout()
    {

        $data   = $this->form->validatePayout();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'setupaccountpopup', action:'hide');
            $this->dispatch('toggleModel', id:'setuppayoneerpopup', action:'hide');
            return;
        }

        $payout = $this->payoutService->addPayoutDetail(Auth::user()->id,$this->form->current_method,$data);
        if( $payout){

            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.payout_account_add'));
        }
        $this->form->reset();
        $this->dispatch('toggleModel', id:'setupaccountpopup', action:'hide');
        $this->dispatch('toggleModel', id:'setuppayoneerpopup', action:'hide');
        $this->dispatch('reload-balances');
        $this->loadData();
    }

    public function removePayout()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'deletepopup', action:'hide');
            return;
        }

        $payout = $this->payoutService->deletePayout(Auth::user()->id,$this->form->current_method);
        if( $payout){
            $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.payout_account_remove'));
        }
        $this->dispatch('toggleModel', id:'deletepopup', action:'hide');
        $this->dispatch('reload-balances');
        $this->loadData();

    }

    public function updateStatus($method)
    {

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $this->payoutService->updatePayoutStatus(Auth::user()->id,$method);
        $this->dispatch('reload-balances');
        $this->loadData();

    }

    public function openPayout($method,$id)
    {
            $this->form->reset();
            $this->form->resetErrorBag();
            $this->form->current_method = $method;
            $this->dispatch('toggleModel', id: $id, action:'show');
    }

}
