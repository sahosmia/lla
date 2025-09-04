<?php

namespace App\Livewire\Pages\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CertificateList extends Component
{


    public $student_id;
    public $certificates;
    public $isLoading = true;
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.student.certificate-list');
    }

    public function mount()
    {
        if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')){
            $this->certificates = get_certificates(['modelable_id' => Auth::id()]);
            $this->isLoading = false;
        }
    }
}
