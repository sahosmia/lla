<?php

namespace App\Livewire\Pages\Common\Dispute;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Services\DisputeService;

class Dispute extends Component
{
    use WithPagination;
    protected $disputeService;
    public $isLoading   = true;
    public $keyword     = '';
    public $perPage     = 10;
    public $status      = '';
    public $user;
    public $sortBy      = 'desc';

    public function boot()
    {
        $this->disputeService = new DisputeService(Auth::user());
        $this->user           = Auth::user();
    }
    
    public function mount()
    {
        $this->perPage      = setting('_general.per_page_record') ?? 10;
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    public function loadData()
    {
        $this->isLoading   = false;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $disputes = $this->disputeService->getDisputes($this->keyword, $this->perPage, $this->status, $this->sortBy);

        return view('livewire.pages.common.dispute.dispute',compact('disputes'));
    }

    public function viewDetail($uuid)
    {       
        if($this->user->role == 'student') {
            return redirect()->route('student.manage-dispute',['id' => $uuid]);
        } else {
            return redirect()->route('tutor.manage-dispute',['id' => $uuid]);
        }
    }
}
