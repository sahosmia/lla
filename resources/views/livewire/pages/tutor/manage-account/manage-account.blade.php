<div class="am-accountwrap" wire:init="loadData">
    @slot('title')
        {{ __('general.dashboard') }}
    @endslot
    @if($isLoading)
        @include('skeletons.manage-account')
    @else
    <div class="am-section-load" wire:loading wire:target="refresh">
        @include('skeletons.manage-account')
    </div>
    <div>
        <div wire:loading.remove wire:target="refresh">
            @include('livewire.pages.tutor.manage-account.wallet-detail')
            @include('livewire.pages.tutor.manage-account.earning-graph')
            <div class="am-dbbox">
                <div class="am-dbbox_title">
                    <h2>{{ __('tutor.setup_payouts_methods') }}</h2>
                </div>
                <div class="am-dbbox_content">
                    <div x-data="{current_method:@entangle('form.current_method')}" class="am-payout_wrap">
                        @php
                        $payout_method = [
                        'paypal' => [
                        'id' => 'PayPal',
                        'title' => __('tutor.payPal_balance'),
                        'image' => 'images/paypal.svg',
                        'price' => $withdrawalsType['paypal']['total_amount'] ?? 0,
                        'status' => isset($payoutStatus['paypal'])?? [],
                        'remove_action' => isset($payoutStatus['paypal']) ? 'deletepopup' : 'setuppayoneerpopup',
                        'btnTitle' => isset($payoutStatus['paypal']) ? __('tutor.remove_account') :
                        __('tutor.add_account')
                        ],
                        'payoneer' => [
                        'id' => 'payoneer',
                        'title' => __('tutor.payoneer_balance') ,
                        'image' => 'images/payoneer.svg',
                        'price' => $withdrawalsType['payoneer']['total_amount'] ?? 0,
                        'status' => isset($payoutStatus['payoneer'] ) ?? [],
                        'remove_action' => isset($payoutStatus['payoneer']) ? 'deletepopup' : 'setuppayoneerpopup',
                        'btnTitle' => isset($payoutStatus['payoneer']) ?__('tutor.remove_account') :
                        __('tutor.add_account')
                        ],
                        'bank' => [
                        'id' => 'bank',
                        'title' => __('tutor.bank_transfer') ,
                        'image' => 'images/bank.svg',
                        'price' => $withdrawalsType['bank']['total_amount'] ?? 0,
                        'status' => isset($payoutStatus['bank']) ??[],
                        'remove_action' => isset($payoutStatus['bank']) ? 'deletepopup' : 'setupaccountpopup',
                        'btnTitle' => isset($payoutStatus['bank']) ?__('tutor.remove_account') : __('tutor.add_account')
                        ],
                        ];
                        @endphp
                        @foreach ($payout_method as $method => $item)
                        <div wire:key=$method.'-'.time()}}" class="am-payout_item">
                            <figure class="am-payout_item_img">
                                <img src="{{ asset($item['image']) }}" alt="img description">
                            </figure>
                            @if ($item['price'])
                            <strong>{!! formatAmount($item['price'], true) !!}</strong>
                            @endif
                            @if ($item['status'])
                            <span>{{ $item['title'] }}</span>
                            @endif
                            <div class="am-radio">
                                @if ($item['status'])
                                <input wire:click="updateStatus('{{ $method }}')" {{
                                    $payoutStatus[$method]['status']=='active' ? 'checked' : '' }} type="radio"
                                    id="default_{{ $method }}" name="method">
                                <label for="default_{{ $method }}">{{ __('tutor.make_default_method') }}</label>
                                @else
                                <strong>{{ $item['title'] }}</strong>
                                @if(!$item['price'] > 0)
                                <span>{{ __('tutor.no_account_added_yet') }}</span>
                                @endif
                                @endif
                            </div>
                            <div class="am-payout_item_remove">
                                @if ($item['status'])
                                <a href="javascript:void(0);"
                                    @click="current_method = @js($method); $wire.dispatch('toggleModel', { id: '{{ $item['remove_action'] }}', action: 'show' });">{{
                                    $item['btnTitle'] }}</a>
                                @else
                                <a href="javascript:void(0);" wire:click="openPayout('{{ $method }}', '{{ $item['remove_action'] }}')">{{ $item['btnTitle'] }}</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="am-payout_description">
                        <p>{{__('tutor.detail')}} <a href="{{ url('terms-condition') }}">{{__('tutor.transfer_policy')}}</a></p>
                    </div>
                </div>
            </div>

        </div>
        <!-- setup account popup modal -->
        <div wire:ignore.self class="modal fade am-setupaccountpopup" id="setupaccountpopup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>{{ __('tutor.setup_bank_account') }}</h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform">
                            <fieldset>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.title')])>
                                    <x-input-label for="accounttitle" class="am-important"
                                        :value="__('tutor.bank_account_title')" />
                                    <x-text-input wire:model="form.title" id="accounttitle" name="accounttitle"
                                        placeholder="{{ __('tutor.enter_bank_account_title') }}" type="text" />
                                    <x-input-error field_name="form.title" />
                                </div>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.accountNumber')])>
                                    <x-input-label for="account" class="am-important"
                                        :value="__('tutor.bank_account_number')" />
                                    <x-text-input wire:model="form.accountNumber" id="account" name="account"
                                        placeholder="{{ __('tutor.enter_bank_account_number') }}" type="text" />
                                    <x-input-error field_name="form.accountNumber" />
                                </div>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.bankName')])>
                                    <x-input-label for="bankname" :value="__('tutor.bank_name')" class="am-important" />
                                    <x-text-input wire:model="form.bankName" id="bankname" name="bankname"
                                        placeholder="{{ __('tutor.enter_bank_name') }}" type="text" />
                                    <x-input-error field_name="form.bankName" />
                                </div>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.bankRoutingNumber')])>
                                    <x-input-label for="routingnum" :value="__('tutor.bank_routing_number')" />
                                    <x-text-input wire:model="form.bankRoutingNumber" id="routingnum" name="routingnum"
                                        placeholder="{{ __('tutor.enter_bank_routing_number') }}" type="text" />
                                    <x-input-error field_name="form.bankRoutingNumber" />
                                </div>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.bankIban')])>
                                    <x-input-label for="bankiban" :value="__('tutor.bank_iban')"/>
                                    <x-text-input wire:model="form.bankIban" id="bankiban" name="bankiban"
                                        placeholder="{{ __('tutor.enter_bank_iban') }}" type="text" />
                                    <x-input-error field_name="form.bankIban" />
                                </div>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.bankBtc')])>
                                    <x-input-label for="bankbic" :value="__('tutor.bank_bic_swift')" />
                                    <x-text-input wire:model="form.bankBtc" id="bankbic" name="bankbic"
                                        placeholder="{{ __('tutor.enter_bank_bic_swift') }}" type="text" />
                                    <x-input-error field_name="form.bankBtc" />
                                </div>
                                <div class="form-group am-form-btns">
                                    <button wire:target="updatePayout" wire:loading.class="am-btn_disable"
                                        wire:click="updatePayout" type="button" class="am-btn">{{
                                        __('tutor.save_update') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- setup payoneer popup modal -->
        <div wire:ignore.self class="modal fade am-setuppayoneerpopup" id="setuppayoneerpopup"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>{{ __('tutor.setup_account',['payout_method' => ucfirst($form?->current_method)]) }}</h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform">
                            <fieldset>
                                <div @class(['form-group', 'am-invalid'=> $errors->has('form.email')])>
                                    <x-input-label for="Email" class="am-important" :value="__('tutor.email_label')" />
                                    <x-text-input id="Email" wire:model="form.email" name="Email"
                                        placeholder="{{ __('tutor.enter_email') }}" type="text" />
                                    <x-input-error field_name="form.email" />
                                </div>
                                <div class="form-group am-form-btns">
                                    <button wire:target="updatePayout" wire:loading.class="am-btn_disable"
                                        wire:click="updatePayout" type="button" class="am-btn">{{
                                        __('tutor.save_update') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete modal -->
        <div wire:ignore.self class="modal fade am-deletepopup" id="deletepopup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-body">
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                        <div class="am-deletepopup_icon">
                            <span><i class="am-icon-trash-02"></i></span>
                        </div>
                        <div class="am-deletepopup_title">
                            <h3>{{ __('tutor.confirm_title') }}</h3>
                            <p>{{ __('tutor.confirm_message') }}</p>
                        </div>
                        <div class="am-deletepopup_btns">
                            <a href="javascript:void(0);"class="am-btn am-btnsmall" data-bs-dismiss="modal">{{ __('tutor.no_button') }}</a>
                            <a href="javascript:void(0);" wire:target="removePayout" wire:loading.class="am-btn_disable" wire:click="removePayout"
                                class="am-btn am-btn-del">{{ __('tutor.yes_button') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@push('styles')
@vite([
'public/css/flatpicker.css',
'public/css/flatpicker-month-year-plugin.css'
])
@endpush

@push('scripts')
<script defer src="{{ asset('js/flatpicker.js') }}"></script>
<script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
<script defer src="{{ asset('js/chart.js')}}"></script>
<script type="text/javascript" data-navigate-once>
        var earningsChart;
        var component = '';
        document.addEventListener('livewire:navigated', function() {
                component = @this;
        },{ once: true });

        document.addEventListener('initChartJs', (event)=>{
            setTimeout(() => {
                initCalendarJs(event.detail.currentDate);
                renderChart(event.detail.data.earnings, event.detail.data.days);
            }, 500);
        })

        function initCalendarJs(defaultDate) {
            $("#calendar-month-year").flatpickr({
                defaultDate: defaultDate,
                disableMobile: true,
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true, //defaults to false
                        dateFormat: "F, Y", //defaults to "F Y"
                    })
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('selectedDate', dateStr);
                }
            });
        }
        function renderChart(earnigns, labels) {
            let days = Object.values(labels).map(day => day.toString());
            var ctx = document.getElementById('am-themechart').getContext('2d');
            if (earningsChart) {
                earningsChart.destroy();
            }
            var gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(117, 79, 254, 0.30)');
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0.00)');

            earningsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Earning',
                        data: earnigns,
                        backgroundColor: gradient,
                        borderColor: '#754FFE',
                        tension : 0.5,
                        borderWidth: 1,
                        fill: true,
                        pointBackgroundColor: '#754FFE',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#754FFE'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x:{
                            grid:{
                                drawTicks:false,
                                // display:false,
                            },

                        },
                        y: {
                            beginAtZero: true,
                            grid:{
                                drawTicks:false,
                            },
                            border:{
                                display:false,
                                dash:[12,12]
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `$${context.formattedValue} Earning`;
                                }
                            }
                        }
                    }
                }
            });
        }
</script>
@endpush
