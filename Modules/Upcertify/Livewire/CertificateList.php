<?php


namespace Modules\Upcertify\Livewire;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Modules\Upcertify\Models\Template;
use Illuminate\Support\Facades\Auth;
use Modules\Upcertify\Models\Certificate;
use Livewire\WithPagination;

class CertificateList extends Component {
    use WithPagination;

    public $tab;
    public $id;
    public $certificate;
    public $categories;
    public $tabs;
    public $title;
    public $isLoading = true;
    
    #[Layout('upcertify::layouts.app')]
    public function render() {
        $templates = Template::where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(15);
        return view('upcertify::livewire.certificate-list.certificate-list', compact('templates'));
    }

    public function mount() {
       
    }

    public function createNow() {
       
        $this->validate([
            'title' => 'required|string|max:255',
        ]);
       
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            $this->dispatch('closeModal');
            return;
        }

        $certificate = Template::updateOrCreate([
            'title' => $this->title,
            'user_id' => Auth::id(),
            'status' => 'draft',
        ]);

        $this->dispatch('showToast', type: 'success', message: __('upcertify::upcertify.certificate_created'));
        sleep(1);
        $this->dispatch('closeModal');
        return redirect()->route('upcertify.update', [
            'id' => $certificate->id,
            'tab' => 'media'
        ]);    
    }

    public function loadData()
    {
        $this->isLoading = false;
    }

    public function deleteTemplate($id) {
        
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showToast', 
               type: 'error',
               message: __('general.demosite_res_txt')
            );
            $this->dispatch('closeModal');
            return;
        }
        $uc_certificate = Certificate::where('template_id', $id)->first();
        $certificate = Template::find($id);
        if($certificate && empty($uc_certificate)) {
            $certificate->delete();
            $this->dispatch('showToast', type: 'success', message: 'Template deleted successfully');
        } else {
            $this->dispatch('showToast', type: 'error', message: 'Template cannot be deleted');
        }
    }
}
