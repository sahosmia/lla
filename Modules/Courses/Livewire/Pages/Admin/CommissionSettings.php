<?php

namespace Modules\Courses\Livewire\Pages\Admin;

use Larabuild\Optionbuilder\Facades\Settings;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CommissionSettings extends Component
{


    public $commission_type     = 'free';
    public $fixed_course_price    = '';
    public $percentage_course_price = '';
    public $currency_symbol     = '';
    public $hourly_price        = '';


    public function mount()
    {
        $this->getSettings();
    }

    public function getSettings(){

        $currency               = setting('_general.currency');
        $getSetting             = setting('admin_settings');
        $currency               = !empty( $currency ) ? $currency : 'USD';
        $selected               = currencyList($currency);
        $this->currency_symbol  = $selected['symbol'];

        if( !empty($getSetting['course_commission_setting']) ){
            $data = $getSetting['course_commission_setting'];
            $this->commission_type = ! empty( $data) ? array_key_first($data) : '';
            if( ! empty( $data[$this->commission_type] ) ){
                $result = $data[$this->commission_type];
                
                if($this->commission_type == 'fixed' ){
                    if(isActiveModule('Courses')){
                        $this->fixed_course_price = !empty($result['course_price']) ? $result['course_price'] : '';
                    }
                } elseif($this->commission_type == 'percentage' ){
                    if(isActiveModule('Courses')){
                        $this->percentage_course_price = !empty($result['course_price']) ? $result['course_price'] : '';
                    }
                }
            }

            $data = !empty( $data[$this->commission_type] ) ? $data[$this->commission_type] : '';
            $this->hourly_price = !empty( $data[$this->commission_type] ) ? $data[$this->commission_type] : '';

        }
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        $data = array();
        $data['hr_comm_range'] = commissionRange('hourly', $this->currency_symbol);
        $data['fix_comm_range'] = commissionRange('fixed', $this->currency_symbol);

        $data['comm_type_opt'] = array(
            'fixed'         => __('settings.comm_type_opt_fixed'),
            'percentage'    => __('settings.comm_type_opt_percentage'),
        );

        return view('courses::livewire.admin.commission-settings', $data );
    }

    public function update(){

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $rules = [
            'commission_type'                      => 'required',
        ];
        if(isActiveModule('Courses')){
            $rules['fixed_course_price'] = 'sometimes|nullable|required_if:commission_type,fixed|numeric|min:0';
            $rules['percentage_course_price'] = 'sometimes|nullable|required_if:commission_type,percentage|numeric|min:1|max:100';
        }
        $this->validate($rules,[
            'required'      => __('general.required_field'),
            'required_if'   => __('general.required_field'),
        ]);

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }

        $data = array();

        if( $this->commission_type == 'fixed' ){
            if(isActiveModule('Courses')){
                $data['fixed']['course_price'] = sanitizeTextField( $this->fixed_course_price ); // Number
            }
        }elseif( $this->commission_type == 'percentage' ) {
            if(isActiveModule('Courses')){
                $data['percentage']['course_price'] = sanitizeTextField( $this->percentage_course_price); // %
            }
        } else {
            $data['free'] = 'free';
        }

        $record =  Settings::set('admin_settings','course_commission_setting',$data);

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
