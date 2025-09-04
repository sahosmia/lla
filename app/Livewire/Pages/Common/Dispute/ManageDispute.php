<?php

namespace App\Livewire\Pages\Common\Dispute;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\DisputeService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageDispute extends Component
{

    protected $disputeService;
    public $id;
    public $userDispute;
    public $user;
    public $chatMessages;
    public $pendingDisputeMessage;
    public $closeDisputeMessage;
    public $admin;
    public $message;
    public function mount($id)
    {
        $this->id           = $this->disputeService->getDisputeId($id);
        $this->user         = Auth::user();
        $this->pendingDisputeMessage = setting('_dispute_setting.pending_dispute_tooltip_message') ?? '';
        $this->closeDisputeMessage = setting('_dispute_setting.close_dispute_tooltip_message') ?? '';
    }

    public function boot()
    {
        $this->disputeService = new DisputeService(Auth::user());
        $this->admin          = User::admin();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $dispute            = $this->disputeService->getDisputeByID($this->id);
        $this->userDispute  = $dispute;
        $userChat           = $this->disputeService->getUserChat($this->id,$this->user->role);
        return view('livewire.pages.common.dispute.manage-dispute', compact('dispute','userChat'));
    }

    public function sendMessage()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        if($this->userDispute?->status == 'pending'|| $this->userDispute?->status == 'closed' || trim($this->message) == '') {
            return;
        }   
        $this->disputeService->sendMessage($this->id, $this->message,$this->user->role);
        $this->message = '';
        $this->dispatch('messageSent');
    }
}
