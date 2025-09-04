<?php
namespace App\Livewire\Pages\Student\BillingDetail;

use App\Livewire\Forms\Student\BillingDetail\BillingDetailForm;
use App\Models\Country;
use App\Services\BillingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BillingDetail extends Component
{

    public BillingDetailForm $form;
    public $states;
    public $countries;
    public $address;
    public $isLoading = true;
    public $hasStates = false;
    public $billingDetail;

    private ?BillingService $billingService = null;

    #[Layout('layouts.app')]
    public function render()
    {
        $this->states = [];
        if(!empty($this->form->country)){
            $this->states = $this->billingService->countryStates($this->form->country);
            if($this->states->isNotEmpty()){
                $this->hasStates = true;
                $this->dispatch('initSelect2', target: '#country_state' );
            } else {
                $this->hasStates = false;
            }
        }
        $enableGooglePlaces           = setting('_api.enable_google_places') ?? '0';
        $googleApiKey           = setting('_api.google_places_api_key');
        return view('livewire.pages.student.billing-detail.billing-detail',compact('enableGooglePlaces','googleApiKey'));
    }

    public function boot() {
        $this->billingService = new BillingService(Auth::user());
    }

    public function loadData()
    {
        $this->isLoading            = false;
        $this->dispatch('loadPageJs');
    }

    public function updatedForm($value, $key)
    {
        if( $key == 'countryName' ) {
            $country = Country::where('short_code',$value)->select('id')->first();
            $this->form->country =  $country->id;
        }
    }

    public function mount(): void
    {
        $this->billingDetail      = $this->billingService->getBillingDetail();
        $this->address      = $this->billingService->getUserAddress();
        $this->countries    = Country::get(['id','name']);
        $this->form->getInfo($this->billingDetail);
        $this->form->setUserAddress($this->address);
        $this->dispatch('initSelect2', target: '.am-select2' );
        $billing_check = setting('_lernen.payment_enabled');
        if($billing_check == 'no'){
            abort(404);
        }
    }

    public function updateInfo()
    {

        $data = $this->form->updateInfo($this->hasStates);
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $billinginfo = $this->billingService->storeBillingDetail($data['billingDetail']);
         if ($billinginfo) {
            $this->billingService->storeBillingAddress($billinginfo->id, $data['address']);
        }
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.success_message'));
    }

}
