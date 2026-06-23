<?php

namespace App\Livewire\Pages\Admin\Payments;

use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;
use App\Models\UserWithdrawal;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class WithdrawRequest extends Component
{
    use WithPagination;
    public $filter_request      = '';
    public $search_request      = '';
    public $date_format         = '';
    public $currency_symbol     = '';
    public $sortby              = 'desc';
    public $per_page            = '';
    public $per_page_opt        = [];
    public $account_info        = [];
    public $request_id          = null;
    public $payment_method      = null;


    public function mount()
    {
        $this->per_page_opt     = perPageOpt();
        $per_page_record        = setting('_general.per_page_record');
        $date_format            = setting('_general.date_format');
        $currency               = setting('_general.currency');
        $this->per_page         = !empty($per_page_record) ? $per_page_record : 10;
        $this->date_format      = !empty($date_format)  ? $date_format : 'm d, Y';
        $currency_detail        = !empty($currency)  ? currencyList($currency) : array();
        if (!empty($currency_detail['symbol'])) {
            $this->currency_symbol = $currency_detail['symbol'];
        }
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $requests = UserWithdrawal::select('id', 'user_id', 'amount', 'payout_method', 'detail', 'status', 'created_at')
            ->with('User:profiles.id,image,first_name,last_name');
        if (!empty($this->search_request)) {
            $requests = $requests->whereHas('User', function ($query) {
                $query->where(function ($sub_query) {
                    $sub_query->whereFullText('first_name', $this->search_request);
                    $sub_query->orWhereFullText('last_name', $this->search_request);
                });
            });
        }

        if ($this->filter_request) {
            $requests = $requests->where('status', $this->filter_request);
        }

        $requests = $requests->orderBy('id', $this->sortby);
        $requests = $requests->paginate($this->per_page);
        return view('livewire.pages.admin.payments.withdraw-request', compact('requests'));
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterRequest', 'searchRequest', 'sortby', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function accountInfo($id)
    {

        $account_info   = UserWithdrawal::select('id', 'payout_method', 'detail')->find($id);
        if (!empty($account_info)) {
            $this->payment_method   = $account_info->payout_method;
            $this->account_info     = $account_info->detail;
            $this->dispatch('openModal');
        }
    }

    #[On('approve-request')]
    public function approveRequest($params)
    {

        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $project_detail = UserWithdrawal::where('status', 'pending')->find($params['id']);
        if ($project_detail) {

            $project_detail->update(['status' => 'paid']);
            dispatch(new SendNotificationJob('acceptedWithdrawRequest', $project_detail->getUser, ['name' => $project_detail->User->full_name, 'amount' => $project_detail->amount,]));
            dispatch(new SendDbNotificationJob('acceptedWithdrawRequest', $project_detail->getUser, ['withdrawAmount' => $project_detail->amount,]));
        }
    }
}
