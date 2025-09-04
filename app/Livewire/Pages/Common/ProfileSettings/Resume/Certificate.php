<?php

namespace App\Livewire\Pages\Common\ProfileSettings\Resume;

use App\Livewire\Forms\Tutor\Certificate\UserCertificateForm;
use App\Services\CertificateService;
use App\Services\EducationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Certificate extends Component
{
    use WithFileUploads;
    public UserCertificateForm $form;
    public $updateMode          = false;
    public $MAX_PROFILE_CHAR    = 500;
    public $certificates        = [];
    public $allowImgFileExt     = [];
    public $activeRoute         = '';
    public $isLoading           = true;
    public $routes              = '';
    public $fileExt             = '';
    public $allowImageSize      = '';
    protected $certificateService;

    public function boot() {
        $this->certificateService   = new CertificateService(Auth::user());
    }
    public function loadData()
    {
        $this->isLoading            = false;
        $this->dispatch('loadPageJs');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if ($this->getErrorBag()->any()) {
            $this->dispatch('loadPageJs');
        }
        $this->certificates   = $this->certificateService->getUserCertificates();
        return view('livewire.pages.common.profile-settings.resume.certificate');
    }

    public function mount(): void
    {
        $image_file_ext          = setting('_general.allowed_image_extensions');
        $image_file_size         = setting('_general.max_image_size');
        $this->fileExt           =  $image_file_ext;
        $this->allowImageSize    = (int) (!empty( $image_file_size ) ? $image_file_size : '3');
        $this->allowImgFileExt   = !empty( $image_file_ext ) ?  explode(',', $image_file_ext) : ['jpg', 'png'];

        $this->activeRoute = Route::currentRouteName();

        $this->routes = [
            [
                'icon'  => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3.3335 15.6667C3.3335 13.4575 5.12436 11.6667 7.3335 11.6667H12.6668C14.876 11.6667 16.6668 13.4575 16.6668 15.6667V15.6667C16.6668 17.1394 15.4729 18.3333 14.0002 18.3333H6.00016C4.5274 18.3333 3.3335 17.1394 3.3335 15.6667V15.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.3335 5.00001C13.3335 6.84095 11.8411 8.33334 10.0002 8.33334C8.15921 8.33334 6.66683 6.84095 6.66683 5.00001C6.66683 3.15906 8.15921 1.66667 10.0002 1.66667C11.8411 1.66667 13.3335 3.15906 13.3335 5.00001Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Education',
                'route' => 'tutor.profile.resume.education',
            ],
            [
                'icon'  => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M0.833496 0.833394L1.25016 0.833344V0.833344C2.48332 0.833374 3.56706 1.65086 3.90583 2.83657L4.04778 3.33339M4.04778 3.33339L5.3406 7.85828C5.816 9.52215 6.05369 10.3541 6.53896 10.9716C6.96727 11.5166 7.52988 11.941 8.17161 12.2031C8.89867 12.5001 9.7639 12.5001 11.4944 12.5001H12.5097C13.5595 12.5001 14.0843 12.5001 14.544 12.3899C15.6414 12.1269 16.5766 11.4125 17.1191 10.423C17.3463 10.0086 17.4844 9.50219 17.7606 8.48945V8.48945C18.0971 7.25575 18.2653 6.6389 18.2327 6.13844C18.1541 4.93155 17.3585 3.8899 16.2148 3.49652C15.7406 3.33339 15.1012 3.33339 13.8225 3.33339H4.04778ZM10.0002 16.6667C10.0002 17.5872 9.25397 18.3333 8.3335 18.3333C7.41302 18.3333 6.66683 17.5872 6.66683 16.6667C6.66683 15.7462 7.41302 15 8.3335 15C9.25397 15 10.0002 15.7462 10.0002 16.6667ZM16.6668 16.6667C16.6668 17.5872 15.9206 18.3333 15.0002 18.3333C14.0797 18.3333 13.3335 17.5872 13.3335 16.6667C13.3335 15.7462 14.0797 15 15.0002 15C15.9206 15 16.6668 15.7462 16.6668 16.6667Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Experience',
                'route' => 'tutor.profile.resume.experience',
            ],
            [
                'icon'  => '<i><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M2.08317 6.66667H17.9165M4.99984 10H8.33317M8.06651 17.5H11.9332C14.1734 17.5 15.2935 17.5 16.1491 17.064C16.9018 16.6805 17.5137 16.0686 17.8972 15.316C18.3332 14.4603 18.3332 13.3402 18.3332 11.1V8.9C18.3332 6.65979 18.3332 5.53968 17.8972 4.68404C17.5137 3.93139 16.9018 3.31947 16.1491 2.93597C15.2935 2.5 14.1734 2.5 11.9332 2.5H8.0665C5.82629 2.5 4.70619 2.5 3.85054 2.93597C3.09789 3.31947 2.48597 3.93139 2.10248 4.68404C1.6665 5.53968 1.6665 6.65979 1.6665 8.9V11.1C1.6665 13.3402 1.6665 14.4603 2.10248 15.316C2.48597 16.0686 3.09789 16.6805 3.85054 17.064C4.70619 17.5 5.82629 17.5 8.06651 17.5Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></i>',
                'title' => 'Certificates & Awards',
                'route' => 'tutor.profile.resume.certificate',
            ]
        ];
    }

    public function storeCertificate(){
        $certificate            = $this->form->validateCertificate();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id:'certificate-popup', action:'hide');
            return;
        }
        $status = $this->certificateService->setUserCertificate($certificate);
        $this->dispatch('toggleModel', id:'certificate-popup', action:'hide');
        $this->updateMode   = false;

        if ($status === 'created') {
            $this->dispatch('showAlertMessage', type: 'success', title: __('certificate.title') , message: __('certificate.certificate_added_message'));
        } else {
            $this->dispatch('showAlertMessage', type: 'success', title: __('certificate.title') , message: __('certificate.certificate_edit_message'));
        }
    }

    public function addCertificate() {
        $this->form->setCertificate();
        $this->resetErrorBag();
        $this->dispatch('toggleModel', id:'certificate-popup', action:'show');
        $this->updateMode   = false;
    }

    public function editCertificate($certificate) {
        $this->form->setCertificate($certificate);
        $this->resetErrorBag();
        $this->dispatch('toggleModel', id:'certificate-popup', action:'show');
        $this->updateMode   = true;
    }

    public function updatedForm($value, $key)
    {
        if( in_array($key, ['image']) ) {
            $mimeType = $value->getMimeType();
            $type = explode('/', $mimeType);
            if($type[0] != 'image') {
                $this->dispatch('showAlertMessage', type: `error`, message: __('validation.invalid_file_type', ['file_types' => fileValidationText($this->allowImgFileExt)]));
                $this->form->{$key} = null;
                return;
            }
        }
    }
    public function removePhoto()
    {
        if (empty($this->form->image)){
            $this->form->old_image  = null;
        } else {
            $this->form->image  = null;
        }
    }

    #[On('delete-certificate')]
    public function deleteCertificate($params = []) {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $deleted = $this->certificateService->deleteCertificate($params['id']);
        if ($deleted) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('certificate.title') , message: __('certificate.certificate_deleted_message'));
        }
    }

}
