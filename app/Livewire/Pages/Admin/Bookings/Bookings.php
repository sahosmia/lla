<?php

namespace App\Livewire\Pages\Admin\Bookings;

use App\Models\SlotBooking;
use App\Services\OrderService;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Bookings extends Component
{
    use WithPagination;

    public      $search             = '';
    public      $sortby             = 'desc';
    public      $status             = '';
    public      $user;
    public      $subjects;
    public      $selectedSubject;
    public      $subjectGroups;
    public      $selectedSubGroup;



    private ?OrderService  $orderService        = null;
    private ?SubjectService  $subjectService    = null;


    public function boot()
    {
        $this->user             = Auth::user();
        $this->orderService     = new OrderService();
        $this->subjectService   = new SubjectService();
    }

    public function mount()
    {

        $this->subjects         = $this->subjectService->getSubjects();
        $this->subjectGroups    = $this->subjectService->getSubjectGroups();

        $this->dispatch('initSelect2', target: '.am-select2' );
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $orders = $this->orderService->getBookings($this->status, $this->search,$this->sortby,$this->selectedSubject,$this->selectedSubGroup);
        return view('livewire.pages.admin.bookings.bookings',compact('orders'));
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['status', 'search', 'sortby', 'selectedSubject','selectedSubGroup'])) {
            $this->resetPage();
        }
    }
}
