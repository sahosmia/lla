<div class="am-checkout_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-checkout_title">
                    @slot('title')
                        {{ __('thank_you.thank_you_page') }}
                    @endslot
                   <strong class="am-checkout_logo">
                       <x-application-logo />
                   </strong>
                   <h2>{{ __('thank_you.thank_you') }}</h2>
                   <p>{{ __('thank_you.you_successfully_submitted') }}</p>
                   <ul class="am-checkout_steptab">
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.select_best_tutor') }}
                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.add_checkout_details') }}
                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            {{ __('thank_you.You_done') }}
                        </li>
                   </ul>
               </div>
            </div>
            <div class="col-12 col-xl-10 offset-xl-1">
                <div class="am-checkout_box">
                    <div class="am-checkout_methods">
                        <div class="am-reschudle-header am-order-confirmed">
                            <span>
                                <i class="am-icon-check-circle06"></i>
                            </span>
                            <h1>{{ __('thank_you.thank_You_for_your_order') }}
                                <strong>{{ __('thank_you.order_reference',['id' => $orderId]) }}</strong>
                            </h1>
                        </div>
                        <div class="am-checkout_perinfo">
                            <p>{!! __('thank_you.thanks_detail') !!}</p> 
                        </div>
                        <div class="am-checkout-details">
                            <a href="{{ auth()->user()->role == 'student' ? route('student.bookings') : route('tutor.invoices') }}" class="am-btn">{{ __('thank_you.continue_profile') }}</a>
                        </div>
                    </div>
                    <div class="am-ordersummary">
                        <div class="am-ordersummary_title">
                            <h3>{{ __('thank_you.order_summary') }}</h3>
                        </div>
                        <ul class="am-ordersummary_list">
                            @php
                                $discount = 0;
                                $total = 0;
                            @endphp
                            @foreach ($orderItem as $item)
                            <li>
                                <figure class="am-ordersummary_list_img">
                                    @if(!empty($item->options['image']) && Storage::disk(getStorageDisk())->exists($item->options['image']))
                                        <img src="{{ resizedImage($item->options['image'],34,34) }}" alt="{{$item->options['image']}}" />
                                    @else
                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="default avatar" />
                                    @endif
                                </figure>
                                <div class="am-ordersummary_list_title">
                                    <div @class(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))])>
                                        @if($item->orderable_type == 'App\Models\SlotBooking')
                                            <span>{{$item->options['session_time']}}</span>
                                            <h3><a href="javascript:void(0);">{{ $item->title }}</a></h3>
                                            <span>{{$item->options['subject_group']}}</span>
                                        @elseif($item->orderable_type == 'Modules\Courses\Models\Course')
                                            <span>{{$item->options['sub_category']}}</span>
                                            <h3><a href="javascript:void(0);">{{ Str::ucfirst($item->title) }}</a></h3>
                                        @elseif($item->orderable_type == 'Modules\Subscriptions\Models\Subscription')
                                            <span>{{ $item->options['period'] }}</span>
                                            <h3><a href="javascript:void(0);">{{ $item->title }}</a></h3>
                                        @elseif($item->orderable_type == 'Modules\CourseBundles\Models\Bundle')
                                            <span>{{ __('coursebundles::bundles.course_bundle') }}</span>
                                            <h3><a href="javascript:void(0);">{{ Str::ucfirst($item->title) }}</a></h3>    
                                        @endif
                                    </div>
                                    <div class="am-ordersummary_list_action">
                                        @if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($item->discount_amount))
                                            <div class="am-ordersummary-discount">
                                                <strike>{!! formatAmount($item->price, true) !!}</strike>
                                                <strong>
                                                    {!! formatAmount(($item->price - ($item->discount_amount ?? 0)), true) !!}
                                                    <span>
                                                        @if($item['cartable_type'] == 'App\Models\SlotBooking')
                                                            <span>/{{ __('checkout.session') }}</span>
                                                        @elseif($item['cartable_type'] == 'Modules\Courses\Models\Course')
                                                            <span>{{ __('tutor.per_course') }}</span>
                                                        @elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle')
                                                            <span>{{ __('coursebundles::bundles.per_bundle') }}</span>                                                                
                                                        @endif
                                                    </span>
                                                </strong>
                                            </div>
                                        @else
                                            <strong>{!! formatAmount($item->price, true) !!}<span>
                                                @if($item->orderable_type == 'Modules\Courses\Models\Course')
                                                    /{{ __('courses::courses.course') }}
                                                @elseif($item->orderable_type == 'App\Models\SlotBooking')
                                                    /{{ __('checkout.session') }}
                                                @elseif($item->orderable_type == 'Modules\CourseBundles\Models\Bundle')
                                                    {{ __('coursebundles::bundles.per_bundle') }}
                                                @endif
                                            </span></strong>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @php
                                if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')){
                                    $discount += $item->discount_amount ?? 0;
                                    $total += ($item->price - ($item->discount_amount ?? 0));
                                }
                            @endphp
                            @endforeach
                        </ul>
                        <ul class="am-ordersummary_price">
                            <li>
                                <span>{{ __('thank_you.subtotal') }}</span>
                                <strong>{!! formatAmount($orderItem[0]->total, true) !!}</strong>
                            </li>
                            @if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $discount > 0)
                                <li>
                                    <span>{{ __('general.discount') }}</span>
                                    <strong>{!! formatAmount($discount, true) !!}</strong>
                                </li>
                            @endif
                            <li class="am-ordersummary_price_total">
                                <span>{{ __('thank_you.grand_total') }}</span>
                                <strong>{!! formatAmount(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') ? $total : $orderItem[0]->total, true) !!}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
