<?php

namespace App\Livewire\Pages\Admin\Payments;
use Larabuild\Optionbuilder\Facades\Settings;
use Modules\LaraPayease\Facades\PaymentDriver;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PaymentMethods extends Component
{

    public $currencies      = [];
    public $methods         = [];
    public $site_currency   = '';
    public $method_type     = '';
    public $edit_method     = '';

    public function mount()
    {
        $this->dispatch('initSelect2', target: '.am-select2' );
        $this->site_currency    = setting('_general.currency');
        $this->currencies       = PaymentDriver::supportedCurrencies();
        $gateways               = $this->rearrangeArray(PaymentDriver::supportedGateways());
        $this->methods          = array_merge($this->methods, $gateways);
        $this->method_type      = setting('admin_settings.default_payment_method') ?? '';
        $this->getSettings();
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $currency_opt               = currencyOptionForPayment();
        $inspection_day_opt         = inspectionPeriodOptions();

        $fee_paid_by_opt = [
           'seller' => __('settings.fee_paid_by_seller_opt'),
           'buyer'  => __('settings.fee_paid_by_buyer_opt'),
           'both'   => __('settings.fee_paid_by_both_opt'),
        ];
        return view('livewire.pages.admin.payments.payment-methods', compact('currency_opt','inspection_day_opt','fee_paid_by_opt',));
    }


    public function getSiteSettings()
    {
        $data = [];
        $payment_methods = setting('admin_settings.payment_method');
        if( !empty($payment_methods) ){
            $data = $payment_methods;
            foreach($data as $key => $value){
                if( array_key_exists('enable_test_mode', $value) ){
                    if(empty($value['enable_test_mode']) ){
                        $data[$key]['enable_test_mode'] = false;
                    }else{
                        $data[$key]['enable_test_mode'] = true;
                    }
                }
            }
        }
        return $data;
    }

    public function getSettings(){
        $payment_methods = $this->getSiteSettings();
        if(!empty($payment_methods)){
            foreach($payment_methods as $type => $value){
                $this->methods[$type] = $value;
            }
        }
    }

    public function updateStatus($method)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        if (array_key_exists($method, $this->methods)) {
            $currentStatus = $this->methods[$method]['status'] ?? 'off';
            if ($currentStatus === 'off') {
                $requiredKeysMissing = false;
                $excludeKeys = ['status', 'webhook_url', 'enable_test_mode', 'exchange_rate'];

                foreach ($this->methods[$method] as $key => $value) {
                    if (!in_array($key, $excludeKeys) && (empty($value) || is_null($value))) {
                        $requiredKeysMissing = true;
                        break;
                    }
                }

                if ($requiredKeysMissing) {
                    $this->dispatch('showAlertMessage', type: 'error', title: __('general.error_title'), message: __('settings.fill_required_keys_first'));
                    $this->dispatch('refreshPage');
                    return;
                }
            }
            
            $payment_methods = $this->getSiteSettings();
            $this->methods[$method]['status'] = $currentStatus === 'on' ? 'off' : 'on';
            $payment_methods[$method] = $this->methods[$method];
            $update = $this->updateSiteSettings($payment_methods);

            if ($update) {
                $this->edit_method = '';
                return true;
            }
        }
        return false;
    }
    

    public function editMethod($key)
    {
        $this->edit_method = $key;
    }

    public function updateSetting()
    {
        $validations = [];
        foreach($this->methods[$this->edit_method] as $key => $value){
            if( in_array($key, ['status','webhook_url','enable_test_mode', 'exchange_rate' ]))
                continue;
            $validations['methods.'.$this->edit_method.'.'.$key] = 'required';
        }
        $this->validate($validations,['required' => __('general.required_field') ]);

        $payment_methods = $this->getSiteSettings();
            if($this->site_currency == ($this->methods[$this->edit_method]['currency']?? null) ){
                $this->methods[$this->edit_method]['exchange_rate'] = '';
            }
            $payment_methods[$this->edit_method] = $this->methods[$this->edit_method];
            $update = $this->updateSiteSettings($payment_methods);

        if($update){
            $this->edit_method = '';
        }else{
        }
    }

    public function updateSiteSettings($data)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $record = Settings::set('admin_settings','payment_method',$data);
        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('settings.updated_record');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }
        $this->dispatch('showAlertMessage', type:  $eventData['type'], title: $eventData['title'] , message:$eventData['message']);
    }

    public function rearrangeArray($array) {
        return array_map(function($details) {
            if (isset($details['keys'])) {
                $details = array_merge($details, $details['keys']);
                unset($details['keys']);
            }
            if (isset($details['ipn_url_type'])) {
                unset($details['ipn_url_type']);
            }
            return $details;
        }, $array);
    }

    public function saveMethod()
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $record =   Settings::set('admin_settings','default_payment_method',$this->method_type);
        if( ! empty( $record ) ){
            $eventData['title']     = __('general.success_title');
            $eventData['message']   = __('settings.updated_record');
            $eventData['type']      = 'success';
        } else {
            $eventData['title']     = __('general.error_title');
            $eventData['message']   = __('settings.wrong_msg');
            $eventData['type']      = 'error';
        }
        $this->dispatch('showAlertMessage', type:  $eventData['type'], title: $eventData['title'] , message:$eventData['message']);
    }


}
