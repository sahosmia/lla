<main class="tb-main tb-mainbg tk-paymentsection">
    <div class="row">
        <div class="col-lg-4 col-md-12 tb-md-40">

            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6>{{__('settings.checkout_method')}}</h6>
                </div>
                <form class="tb-todobox">
                    <fieldset>
                        <div class="form-group-wrap">
                            <div class="form-group">
                                <label class="tk-label">{{__('settings.method_placeholder')}}</label>
                                <div class="tk-settingarea @error('method_type') tk-invalid @enderror">
                                    <div wire:ignore class="tb-select">
                                        <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true"  data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.method_placeholder')}}" id="tk_checkout_method" data-wiremodel="method_type">
                                            <option></option>
                                            @foreach ($methods as $method => $data)
                                              <option value={{ $method }} {{ $method_type == $method ? 'selected' : '' }} >{{__("settings." .$method. "_title")}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('method_type')
                                    <div class="tk-errormsg">
                                        <span>{{$message}}</span>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click="saveMethod" class="tb-btn ">
                                    {{ __('settings.save_method') }}
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="tb-dbholder tb-package-settings">
                <div class="tb-payment-methods_title">
                    <h6>{{__('settings.payment_methods')}}</h6>
                </div>
                <ul class="tb-payment-methods_list">
                    @foreach($methods as $method => $data)
                        <li>
                            <div class="tb-payment-items">
                                <div class="tb-paymethod-items">
                                    <img src="{{asset('images/payment_methods/'.$method. '.png')}}" alt="{{__("settings." .$method. "_title")}}">

                                    <h6>{{__("settings." .$method. "_title")}}</h6>
                                </div>
                                <div class="tb-paymethod-items">
                                    @if($method != 'escrow')
                                        <div class="checkbox">
                                            <input type="checkbox" wire:change="updateStatus('{{ $method }}')" @if($methods[$method]['status'] == 'on') checked @endif>
                                            <label for="{{$method.'_method'}}" class="text"></label>
                                        </div>
                                    @endif
                                    <div class="tb-paymethodedit">
                                        <a href="javascript:void(0);" wire:click.prevent="editMethod('{{$method}}')" >{{__('settings.edit')}} <i class="icon-edit-3"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 tb-md-60" wire:loading.class="tk-section-preloader" wire:target="editMethod">
            <div class="preloader-outer" wire:loading wire:target="editMethod">
                <div class="tk-preloader">
                    <img class="fa-spin" src="{{ asset('images/loader.png') }}">
                </div>
            </div>
            @if($edit_method)
                <div class="tb-payment-methods">
                    <div class="tb-payment-methods_title">
                        <h6>{{__('settings.'. $edit_method .'_payment_title')}}</h6>
                    </div>
                    <form class="tb-themeform tb-payment-settings">
                        <fieldset>
                            <div class="form-group-wrap">
                                @if($edit_method == 'escrow')
                                    <div class="form-group form-group-half">
                                        <label class="tk-label">{{__('settings.escrow_email')}}</label>
                                        <input type="text" class="form-control @error('methods.escrow.email') tk-invalid @enderror" wire:model.defer="methods.escrow.email" placeholder="{{__('settings.escrow_email_placeholer')}}">
                                        @error('methods.escrow.email')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                        <span class="tb-form-span"> {!! __('settings.escrow_email_desc', ['escrow_site_link' => '<a target="_blank" href="https://www.escrow.com/login-page">'. __("settings.escrow_site").' </a>']) !!}</span>
                                    </div>
                                    <div class="form-group form-group-half">
                                        <label class="tk-label">{{__('settings.escrow_api_key')}}</label>
                                        <input type="text" wire:model.defer="methods.escrow.api_key" class="form-control @error('methods.escrow.api_key') tk-invalid @enderror" placeholder="{{__('settings.escrow_api_key_placeholer')}}">
                                        @error('methods.escrow.api_key')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                        <span class="tb-form-span">{!!__('settings.api_key_desc',['get_api_key'=> '<a target="_blank" href="https://www.escrow.com/">'. __("checkout.escrow_site_title").' </a>' ]) !!}</span>
                                    </div>
                                    <div class="form-group ">
                                        <label class="tk-label">{{__('settings.escrow_url')}}</label>
                                        <input type="text" wire:model.defer="methods.escrow.api_url" class="form-control" placeholder="{{__('settings.escrow_url_placeholer')}}">
                                        @error('methods.escrow.api_url')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                        <span class="tb-form-span">
                                            {!!
                                                __('settings.escrow_url_desc',
                                                [
                                                    'production_url'   => '<a target="_blank" href="https://api.escrow.com/">'. __("settings.escrow_production_url").' </a>',
                                                    'testing_url'      => '<a target="_blank" href=" https://api.escrow-sandbox.com/">'. __("settings.escrow_testing_url").' </a>'
                                                ])
                                            !!}
                                        </span>
                                    </div>
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label">{{__('settings.currency')}}</label>
                                        <div wire:ignore class="tb-select border-0">
                                            <select  id="tk_currency" data-method="escrow" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.currency')}}" class="form-control tk-select2">
                                                <option></option>
                                                @foreach( $currency_opt as $key => $currency )
                                                    <option value="{{ $key }}" {{ $methods['escrow']['currency'] == $key ? 'selected' : '' }} >{{ $currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('methods.escrow.currency')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group form-group-3half">
                                        <label class="tk-label">{{__('settings.inspection_period')}}</label>
                                        <div wire:ignore class="tb-select">
                                            <select id="tk_insp_period" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.insp_period_placeholder')}}" class="form-control tk-select2">
                                                <option></option>
                                                @foreach( $inspection_day_opt as $key => $day )
                                                    <option value="{{ $key }}" {{ $methods['escrow']['inspection_period'] == $key ? 'selected' : '' }} >{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('methods.escrow.inspection_period')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group form-group-3half">
                                        <label class="tk-label">{{__('settings.fee_paid_by')}}</label>
                                        <div wire:ignore class="tb-select border-0">
                                            <select id="tk_fees_payer" data-hide_search_opt="true" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.fee_paid_by_placeholder')}}" class="form-control tk-select2">
                                                <option></option>
                                                @foreach( $fee_paid_by_opt as $key => $day )
                                                    <option value="{{ $key }}" {{ $methods['escrow']['fees_payer'] == $key ? 'selected' : '' }} >{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('methods.escrow.fees_payer')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    </div>
                                @else
                                    @foreach ($methods[$edit_method] as $key => $value)
                                        @if($key == 'status') @continue @endif
                                        @if( $key == 'exchange_rate' && (!empty($methods[$edit_method]['currency']) && $methods[$edit_method]['currency'] == $site_currency ) ) @continue @endif
                                        @if($key == 'enable_test_mode')
                                            <div id="{{ $key }}_field" class="form-group form-group-half tb-testmode-wrapper">
                                                <div class="tb-paymethod-items tb-test-opt px-0">
                                                    <div class="checkbox tb-payment-items">
                                                        <input type="checkbox" wire:model="{{ 'methods.'.$edit_method.'.'. $key }}" id="{{ $method.'_test_mode' }}">
                                                        <span for="{{$method.'_test_mode'}}" class="tk-label text"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div id="{{ $key }}_field" class="form-group form-group-half">
                                                <label class="tk-label @if($key !== 'exchange_rate' && $key !== 'currency') tb-important @endif">{{__('settings.'.$key)}}
                                                    @if($key == 'exchange_rate')
                                                        ( 1 {{ $this->site_currency }} = 1 {{ $methods[$edit_method]['currency'] }} )
                                                    @endif
                                                </label>
                                                @if($key == 'currency')
                                                    <div class="tb-select border-0">
                                                        <select id="tk_def_currency" wire:model="{{ 'methods.'.$edit_method.'.'. $key }}" data-method="{{ $edit_method }}" data-placeholderinput="{{__('settings.search')}}" data-placeholder="{{__('settings.currency')}}" class="form-control tk-select">
                                                            @foreach( $currencies[$edit_method] as $currency )
                                                                <option value="{{ $currency }}" {{ $methods[$edit_method][$key] == $currency ? 'selected' : '' }} >{{ $currency }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <input type="text" class="form-control @error('methods.'.$edit_method.'.'. $key) tk-invalid @enderror" wire:model.defer="{{ 'methods.'.$edit_method.'.'. $key }}" placeholder="{{ __('settings.enter_value') }}">
                                                @endif

                                                @error('methods.'.$edit_method.'.'. $key)
                                                    <div class="tk-errormsg">
                                                        <span>{{$message}}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="tb-updatesave-btn">
                                <a href="javascript:void(0);" wire:click.prevent="updateSetting" class="tb-btn">
                                    {{ __('settings.save_setting') }}
                                </a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            @else
                <div class="tb-payment-methods tb-emptypaysetting">
                    <img class="tb-empty-img" src="{{asset('images/empty.png')}}" alt="images">
                    <h2 class="tb-empty">{!! __('settings.empty_setting_desc', ['edit_btn_txt' => '<a href="javascript:;">'. __("settings.edit_txt").' <i class="icon-edit-3"></i></a>']) !!}</h2>
                </div>
            @endif

        </div>
    </div>
</main>
@push('scripts')
<script>
    window.addEventListener('editMethod', function (event){
        jQuery('#tk_currency').on('change', function (e) {
            let _this = jQuery(this);
            let method = _this.data('method');
            let currency = jQuery('#tk_currency').select2("val");
            @this.set('methods.'+method+'.currency', currency);
        });

        jQuery('#tk_insp_period').on('change', function (e) {
            let value = jQuery('#tk_insp_period').select2("val");
            @this.set('methods.escrow.inspection_period', value, true);
        });

        jQuery('#tk_fees_payer').on('change', function (e) {
            let value = jQuery('#tk_fees_payer').select2("val");
            @this.set('methods.escrow.fees_payer', value, true);
        });
    });
    document.addEventListener('livewire:initialized', () => {
        @this.on('refreshPage', () => {
            window.location.reload();
        });
    });
</script>
@endpush
