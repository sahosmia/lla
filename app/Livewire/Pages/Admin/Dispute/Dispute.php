<?php

namespace App\Livewire\Pages\Admin\Dispute;
use Livewire\Attributes\Layout;

use Livewire\Component;
use App\Services\DisputeService;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dispute extends Component
{
    use WithPagination;

    protected $disputeService;
    public $isLoading   = true;
    public $keyword     = '';
    public $perPage     = 10;
    public $status      = '';
    public $sortby      = 'desc';

    public function boot()
    {
        $this->disputeService = new DisputeService(Auth::user());
    }

    public function loadData()
    {
        $this->isLoading   = false;
    }

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $disputes = $this->disputeService->getAllDisputes($this->keyword, $this->perPage, $this->status, $this->sortby);
        return view('livewire.pages.admin.dispute.dispute',compact('disputes'));
    }
    
    public function viewDetail($id)
    {
        return redirect()->route('admin.manage-dispute', $id);
    }
}
