<main wire:loading.class="am-isloading" wire:target="removeCoupon, removeCart" class="am-main">
    <div class="am-section-load" wire:loading.flex wire:target="removeCoupon, removeCart">
        <p>{{ __('general.loading') }}</p>
    </div>
    <div class="am-checkout_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-checkout_title">
                        @slot('title')
                            {{ __('checkout.checkout') }}
                        @endslot
                        <strong class="am-checkout_logo">
                            <x-application-logo />
                        </strong>
                        <h2>{{ __('checkout.you_almost_there') }}</h2>
                        <p>{{ __('checkout.fill_details_mentioned_below_purchase_courses') }}</p>
                        <ul class="am-checkout_steptab">
                            <li class="am-checkout_steptab_checked">
                                <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                                {{ __('checkout.select_best_tutor') }}
                            </li>
                            <li class="am-checkout_steptab_active">
                                <span><i class="am-icon-lock-close"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                {{ __('checkout.add_checkout_details') }}
                            </li>
                            <li>
                                <span><i class="am-icon-flag-02"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                {{ __('checkout.you_done') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12" x-data="{
                    form:@entangle('form'),
                    charLeft:500,
                    init(){
                        this.updateCharLeft();
                    },
                    tutorInfo:{},
                    updateCharLeft() {
                        let maxLength = 500;
                        if (this.form.dec.length > maxLength) {
                            this.form.dec = this.form.dec.substring(0, maxLength);
                        }
                        this.charLeft = maxLength - this.form.dec.length;
                    }
                }">
                    <div class="am-checkout_box">
                        <div class="am-checkout_methods">
                            <div class="am-checkout_methods_title">
                                <h3>{{ __('checkout.payment_methods') }} </h3>
                                <p>{{ __('checkout.secure_and_convenient_payment_purchase') }}</p>
                            </div>
                            <div class="am-checkout_accordion">
                                @if($available_payment_methods)
                                    @foreach ($available_payment_methods as $method => $available_method)
                                        @if ($available_method['status'] == 'on')
                                            <div class="accordion-item">
                                                <div class="am-radiowrap">
                                                    <div class="am-radio">
                                                    <input wire:model.lazy="form.paymentMethod"  {{ $form->paymentMethod == $method ? 'checked' : '' }}  type="radio" id="payment-{{$method}}" name="payment" value={{$method}} >
                                                    <label for="payment-{{$method}}">
                                                        {{__("settings." .$method. "_title")}}
                                                        <figure class="am-radiowrap_img">
                                                            <img src="{{asset('images/payment_methods/'.$method. '.png')}}" alt="{{__("settings." .$method. "_title")}}">
                                                        </figure>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && !empty($subscriptions))
                                    @foreach ($subscriptions as $item)
                                        <div class="accordion-item am-learner-plan">
                                            <div class="am-radiowrap">
                                                <div class="am-radio">
                                                    <input wire:model.lazy="chosenSubscription"  {{ $chosenSubscription == $item->subscription_id ? 'checked' : '' }}  type="radio" id="payment-{{$item->subscription_id}}" name="payment" value={{$item->subscription_id}} >
                                                    <label for="payment-{{$item->subscription_id}}">
                                                        {{ __('subscriptions::subscription.subscription') }}
                                                        <span class="am-radiowrap-img">{!! formatAmount($item?->price, true) !!} <em>/ {{ __('subscriptions::subscription.'.$item->subscription?->period) }}</em></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="am-learner-plan_options">
                                                <h4>{{ $item->subscription?->name }}</h4>
                                                <ul>
                                                    <li>
                                                        <span>{{ __('subscriptions::subscription.max_sessions_'.auth()->user()->role) }}</span>
                                                        <em>{{ $item->remaining_credits['sessions'] ?? 0 }} {{ __('subscriptions::subscription.left') }}</em>
                                                    </li>
                                                    @if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses'))    
                                                        <li>
                                                            <span>{{ __('subscriptions::subscription.max_courses_'.auth()->user()->role) }}</span>
                                                            <em>{{ $item->remaining_credits['courses'] ?? 0 }} {{ __('subscriptions::subscription.left') }}</em>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if(!$checkoutReady)
                                <span class="am-error-msg">{!! __('subscriptions::subscription.not_applicable_to_cart_item', ['name' => $invalidCartItem['name'] ?? '']) !!}</span>
                            @endif
                            <div class="am-checkout_perinfo">
                                <span> <i class="am-icon-lock-close"></i> </span>
                                <p>{{ __('checkout.personal_data') }}</p>
                            </div>
                            <x-input-error field_name="form.paymentMethod" />
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend>{{ __('checkout.billing_details') }}</legend>
                                    </div>
                                    <div @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.firstName')])>
                                        <input wire:model="form.firstName" type="text" class="form-control"  placeholder="Add first name">
                                        <x-input-error field_name="form.firstName" />

                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.lastName')])>
                                        <input wire:model="form.lastName" type="text" class="form-control"  placeholder="Add last name">
                                        <x-input-error field_name="form.lastName" />
                                    </div>
                                    <div @class(['form-group', 'am-invalid' => $errors->has('form.company')]) class="">
                                        <input wire:model="form.company" type="text" class="form-control"  placeholder="Add company title">
                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.email')]) class="">
                                        <input wire:model="form.email" type="text" class="form-control"  placeholder="Add email">
                                        <x-input-error field_name="form.email" />
                                    </div>
                                    <div  @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.phone')])>
                                        <input wire:model="form.phone" type="text" class="form-control"  placeholder="Add phone number">
                                        <x-input-error field_name="form.phone" />
                                    </div>
                                    <div class="form-group">
                                        <x-input-label for="country" :value="__('profile.country')" />
                                        <div @class(['form-control_wrap', 'am-invalid' => $errors->has('form.country')])>
                                             <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="@this" data-live="true" data-searchable="true" id="country" data-wiremodel="form.country">
                                                    <option value="">{{ __('profile.select_a_country') }}</option>
                                                    @foreach ($countries as $item)
                                                        <option value="{{ $item->id }}" {{ $item->id == $form->country ? 'selected' : '' }} >{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                    <div  @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.city')])>
                                        <input wire:model="form.city" type="text" class="form-control"  placeholder="Add town/city">
                                        <x-input-error field_name="form.city" />
                                    </div>
                                    <div @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.state')])>
                                        <input wire:model="form.state" type="text" class="form-control"  placeholder="Add state/country">
                                        <x-input-error field_name="form.state" />
                                    </div>
                                    <div @class(['form-group form-group-3half', 'am-invalid' => $errors->has('form.zipcode')])>
                                        <input wire:model="form.zipcode" type="text" class="form-control"  placeholder="Add postcode/zip">
                                        <x-input-error field_name="form.zipcode" />
                                    </div>
                                </fieldset>
                            </form>
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend>{{ __('checkout.additional_information') }}</legend>
                                    </div>
                                    <div class="form-group">
                                        <textarea wire:model='form.dec' class="form-control" placeholder="{{ __('checkout.note_about_your_order') }}" x-on:input="updateCharLeft" ></textarea>
                                        <span class="am-charleft" x-text="charLeft + ' {{ __('general.char_account') }}'"></span>
                                        <x-input-error field_name="form.dec" />
                                    </div>
                                    @if ($walletBalance)
                                    <div class="form-group">
                                        <div class="am-checkbox ">
                                            <input wire:model.live="useWalletBalance" id="remember_me" type="checkbox" name="remember">
                                            <label for="remember_me">
                                                <strong><span>{{ __('general.wallet_balance') }}</span><sup>{{ getCurrencySymbol() }}</sup>{{  $walletBalance }}</strong>
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group form-groupbtns">
                                        <x-primary-button @class(['am-btn_disabled' => !$checkoutReady]) wire:click="updateInfo" wire:target="updateInfo" type=button wire:loading.class="am-btn_disable" >{{ __('checkout.pay') }} {!! formatAmount($payAmount) !!}<i class="am-icon-arrow-right"></i></x-primary-button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        @if ($content->count() > 0)
                            <div class="am-ordersummary">
                                <div class="am-ordersummary_title">
                                    <h3>{{ __('checkout.order_summary') }}</h3>
                                </div>
                                <ul class="am-ordersummary_list">
                                    @foreach ($content as $item)
                                        <li>
                                            <figure class="am-ordersummary_list_img">
                                                @if (!empty($item['options']['image']) && Storage::disk(getStorageDisk())->exists($item['options']['image']))
                                                    <img src="{{ resizedImage($item['options']['image'],34,34) }}" alt="{{$item['options']['image']}}" />
                                                @else
                                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="default avatar" />
                                                @endif
                                            </figure>
                                            <div class="am-ordersummary_list_title">
                                                <div @class(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))])>
                                                    @if($item['cartable_type'] == 'App\Models\SlotBooking')
                                                        <span>{{$item['options']['session_time']}}</span>
                                                        <h3><a href="javascript:void(0);">{{ $item['name'] }}</a></h3>
                                                        <span>{{$item['options']['subject_group']}}</span>
                                                    @elseif($item['cartable_type'] == 'Modules\Courses\Models\Course')
                                                        <span>{{$item['options']['sub_category']}}</span>
                                                        <h3><a href="javascript:void(0);">{{ $item['name'] }}</a></h3>
                                                    @elseif($item['cartable_type'] == 'Modules\Subscriptions\Models\Subscription')
                                                        <span>{{ $item['options']['period'] }}</span>
                                                        <h3><a href="javascript:void(0);">{{ $item['name'] }}</a></h3>
                                                    @elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle')
                                                        <span>{{ __('coursebundles::bundles.course_bundle') }}</span>
                                                        <h3><a href="javascript:void(0);">{{ $item['name'] }}</a></h3>    
                                                    @endif
                                                </div>
                                                <div class="am-ordersummary_list_action">
                                                    @if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($item['discounted_total']))
                                                        <div class="am-ordersummary-discount">
                                                            <strike>{!! formatAmount($item['price'], true) !!}</strike>
                                                            <strong>{!! $item['discounted_total'] !!}<span>/{{$item['cartable_type'] == 'App\Models\SlotBooking' ? __('checkout.session')  : __('courses::courses.course')}}</span></strong>
                                                        </div>
                                                    @else
                                                        <strong>{!! formatAmount($item['price'], true) !!}
                                                            @if($item['cartable_type'] == 'App\Models\SlotBooking')
                                                                <span>/{{ __('checkout.session') }}</span>
                                                            @elseif($item['cartable_type'] == 'Modules\Courses\Models\Course')
                                                                <span>{{ __('tutor.per_course') }}</span>
                                                            @elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle')
                                                                <span>{{ __('coursebundles::bundles.per_bundle') }}</span>                                                                
                                                            @endif
                                                        </strong>
                                                    @endif
                                                    <a wire:click='removeCart({{ $item['cartable_id'] }}, @json($item['cartable_type']))'  href="javascript:void(0);">{{ __('checkout.remove') }}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="am-ordersummary_price">
                                    <li>
                                        <span>{{ __('checkout.subtotal') }}</span>
                                        <strong>{!! formatAmount($subTotal, true) !!}</strong>
                                    </li>
                                    @if( !empty($extraFee) && $extraFee > 0 && !empty(setting('_platform_fee.platform_fee_title')))
                                        <li>
                                            <span>{{ setting('_platform_fee.platform_fee_title') }}</span>
                                            <strong>{!! formatAmount($extraFee, true) !!}</strong>
                                        </li>
                                    @endif
                                    @if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $discount > 0)
                                        <li>
                                            <span>{{ __('general.discount') }}</span>
                                            <strong>{!! formatAmount($discount, true) !!}</strong>
                                        </li>
                                    @endif
                                    <li class="am-ordersummary_price_total">
                                        <span>{{ __('checkout.grand_total') }}</span>
                                        <strong>{!! formatAmount($totalAmount, true) !!}</strong>
                                    </li>
                                </ul>
                                @if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $content->count() > 0)
                                    @php
                                        $cartHasCoupon = false;
                                        $appliedCoupons = [];
                                        foreach ($content as $item) {
                                            if(!empty($item['options']['discount_code']) && !empty($item['options']['discount_type']) && !empty($item['options']['discount_color']) && !empty($item['options']['discount_value'])){
                                                $cartHasCoupon = true;
                                                    break;
                                            }
                                        }
                                    @endphp
                                    <div class="am-checkout_coupons">
                                        @if($cartHasCoupon)
                                            <div class="am-checkout_coupons_title">
                                                <h3>{{ __('kupondeal::kupondeal.applied_coupon') }}</h3>
                                            </div>
                                            <ul class="am-allcoupons_list">
                                            @foreach ($content as $item)
                                                @if(
                                                    !in_array(($item['options']['discount_code'] ?? ''), $appliedCoupons) &&
                                                    !empty($item['discount_amount']) &&
                                                    !empty($item['options']['discount_code']) &&
                                                    !empty($item['options']['discount_type']) &&
                                                    !empty($item['options']['discount_color']) &&
                                                    !empty($item['options']['discount_value'])
                                                )
                                                    <li>
                                                        <div class="am-coupon_item">
                                                            <div class="am-coupon_header" style="background-color: {{ $item['options']['discount_color'] }};">
                                                                <span>
                                                                    @if($item['options']['discount_type'] == 'percentage')
                                                                        {{ $item['options']['discount_value'] }}<sup>%</sup>
                                                                    @else
                                                                        {!! formatAmount($item['options']['discount_value'], true) !!}
                                                                    @endif
                                                                    <em>{{ __('general.discount') }}</em>
                                                                </span>
                                                                <div class="am-coupon_shape" style="border-color: {{ $item['options']['discount_color'] }}"></div>
                                                            </div>
                                                            <div class="am-coupon_body" style="background-color: {{ addColorOpacity($item['options']['discount_color']) }}">
                                                                <h3 x-data="{ copied: false, textToCopy: '{{ $item['options']['discount_code'] }}' }">
                                                                    <em>{{ __('kupondeal::kupondeal.promo_code') }}</em>
                                                                    {{ $item['options']['discount_code'] }}
                                                                    <a href="javascript:void(0);" @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => {})">
                                                                        <i class="am-icon-copy-01"></i>
                                                                    </a>
                                                                    <template x-if="copied">
                                                                        <span x-show="copied" x-transition>{{ __('general.copied') }}</span>
                                                                    </template>
                                                                </h3>
                                                                @if($item['options']['auto_apply'] != '1')
                                                                    <a href="javascript:void(0);" class="am-removecoupon" wire:click="removeCoupon('{{ $item['options']['discount_code'] }}')"><i class="am-icon-multiply-02"></i></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                                @php
                                                        if(!empty($item['options']['discount_code'])){
                                                            $appliedCoupons[] = $item['options']['discount_code'];
                                                        }
                                                    @endphp
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div class="am-checkout_coupons_footer">
                                            <input type="text" wire:model="coupon" class="form-control" placeholder="{{ __('kupondeal::kupondeal.enter_coupon') }}">
                                            <a href="javascript:void(0);" wire:loading.class="am-btn_disable" wire:target="applyCoupon" wire:click="applyCoupon" class="am-btn">{{ __('kupondeal::kupondeal.apply') }}</a>
                                        </div>
                                        @error('coupon')
                                            <span class="am-error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@if(session()->get('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.dispatch('showAlertMessage', {
            type: 'error',
            message: "{{ session()->get('error') }}"
        });
    });
</script>
@endif

