<main class="tb-main tb-commissionwrap">
    <div class="tb-dbholder tb-dbholdervtwoa">
        <div class="tb-sectiontitle">
            <h5> {{__('settings.commission_settings')}}</h5>
        </div>
        <div class="tb-dbsettingbox">
            <form class="tb-comiisionform">
                <fieldset>
                    <div class="tb-themeform__wrap">
                        <div class="tb-commisionarea">
                            <span class="tb-titleinput">{{__('settings.project_commission_free')}}</span>
                            <div class="tb-radiotabwrap">
                                <div class="tb-radiowrap">
                                    <label for="free">
                                        <input type="radio" wire:model.lazy="commission_type" id="free" value="free" {{ $commission_type == 'free' ? 'checked' : '' }}/>
                                        <span>{{__('settings.no_commission')}}</span>
                                    </label>
                                </div>
                                <div class="tb-radiowrap">
                                    <label for="fixed">
                                        <input type="radio" wire:model.lazy="commission_type" id="fixed" value="fixed" {{ $commission_type == 'fixed' ? 'checked' : '' }} />
                                        <span>{{__('settings.fixed_commission')}}</span>
                                    </label>
                                </div>
                                <div class="tb-radiowrap">
                                    <label for="percentage">
                                        <input type="radio" wire:model.lazy="commission_type" id="percentage" value="percentage" {{ $commission_type == 'percentage' ? 'checked' : '' }} />
                                        <span>{{__('settings.percentage_commission')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="tb-nocommision @if( $commission_type == 'free' ) d-flex @else d-none @endif">
                            <img src="{{asset('images/empty.png')}}" alt="">
                            <span>{{__('settings.no_commission_desc')}}</span>
                        </div>

                        <div class="tb-commision @if( in_array( $commission_type, ['fixed', 'percentage']) ) d-block @else d-none @endif">
                            <div class="tb-formcomision">
                                <div class="form-group form-vertical">
                                    <label class="tb-titleinput tk-required">{{__('settings.fixed_commission_price')}}</label>
                                    @if( $commission_type == 'fixed' )
                                        <div class="form-group form-vertical tb-inputiconleft">
                                            <input type="number" wire:model.defer="fix_fixed_price" class="form-control @error('fix_fixed_price') tk-invalid @enderror" placeholder="{{__('settings.fixed_price_placeholder')}}">
                                            <i class="icon-dollar-sign"></i>
                                        </div>
                                        @error('fix_fixed_price')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    @else
                                        <div class="form-group form-vertical tb-inputiconleft">
                                            <input type="number" wire:model.defer="per_fixed_price" class="form-control @error('per_fixed_price') tk-invalid @enderror" placeholder="{{__('settings.percentage_amount_placeholder')}}">
                                            <i class="icon-percent"></i>
                                        </div>
                                        @error('per_fixed_price')
                                            <div class="tk-errormsg">
                                                <span>{{$message}}</span>
                                            </div>
                                        @enderror
                                    @endif
                                    <span>{{__('settings.fixed_price_desc')}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group tb-dbtnarea">
                            <a href="javascript:void(0);" wire:click.prevent="update" class="tb-btn ">
                                {{ __('settings.save_setting') }}
                            </a>
                        </div>

                </fieldset>
            </form>
        </div>
    </div>
</main>
