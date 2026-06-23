<div class="am-sidebar">
    <div class="am-sidebar_logo">
        <strong class="am-logo">
            <x-application-logo />
        </strong>
        <div class="am-sidebar_toggle">
            <a href="javascript:void(0);">
                <i class="am-icon-dashbard"></i>
            </a>
        </div>
    </div>
    <nav class="am-navigation">
        <ul>
            @foreach ( $menuItems as $item)
                @if(in_array($role, $item['accessibility']))
                <li @class([
                    'am-active-nav' => in_array($activeRoute, $item['onActiveRoute']),
                    'sidebar-sub-menu' => !empty($item['children'])
                ])>
                    @if (!empty($item['route']))
                        <a href="{{ route($item['route']) }}" {{ empty($item['disableNavigate'])  ? 'wire:navigate.remove' : '' }}>
                            {!! $item['icon'] !!}
                            {{ $item['title'] }}
                        </a>
                    @else
                        <a href="#" {{ empty($item['disableNavigate'])  ? 'wire:navigate.remove' : '' }}>
                            {!! $item['icon'] !!}
                            {{ $item['title'] }}
                        </a>
                    @endif
                    
                    @if (!empty($item['children']))
                        <ul class="am-submenu">
                            @foreach ($item['children'] as $child) 
                                <li @if(Route::currentRouteName() == $child['route']) class="am-active" @endif>
                                    <a href="{{ route($child['route']) }}" {{ empty($child['disableNavigate'])  ? 'wire:navigate.remove' : '' }}>
                                        {{ $child['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                @endif
            @endforeach
        </ul>
    </nav>
    <div class="am-navigation_footer">
        <div class="am-wallet">
            <div class="am-wallet_title">
                <span class="am-wallet_title_icon">
                    <i class="am-icon-invoices-01-5"></i>
                </span>
                <div class="am-wallet_balance">
                    <strong>{!! formatAmount($balance, true) !!}<span>{{ __('general.wallet_balance') }}</span></strong>
                </div>
            </div>
            <a href="javascript:void(0);" wire:click="openModel"  class="am-wallet_withdraw">
                {{ __('general.withdraw_now') }}
            </a>
        </div>
        <div class="am-signout" wire:click="logout">
            <a href="javascript:void(0);" class="am-signout_nav">
                <i class="am-icon-sign-out-02"></i>
                {{ __('general.sign_out') }}
            </a>
        </div>
    </div>
    <div wire:ignore.self class="modal fade am-setuppayoneerpopup" id="amount" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2>{{ __('tutor.setup_payoneer_account',['payout_method' => ucfirst($userPayoutMethod?->payout_method)]) }}</h2>
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <figure class="am-setup_img">
                        <img src="{{ asset('images/account-info-bg.png') }}" alt="img description">
                        <figcaption class="am-setup_img_content">
                            <span>{{ ucfirst($userPayoutMethod?->payout_method) }}</span>
                            <figure class="am-setup_img_icon">
                                @if ($userPayoutMethod?->payout_method == 'paypal')
                                    <img src="{{ asset('images/paypal.svg') }}" alt="img description">
                                @elseif ($userPayoutMethod?->payout_method == 'payoneer')
                                    <img src="{{ asset('images/payoneer.svg') }}" alt="img description">
                                @endif
                            </figure>
                        </figcaption>
                    </figure>
                    <form class="am-themeform">
                        <fieldset>
                            <div @class(['form-group', 'am-invalid' => $errors->has('amount')])>
                                <x-input-label for="amount" class="am-important" :value="__('tutor.withdraw_amount')" />
                                <div class="am-maxamount">
                                    <x-text-input id="amount" wire:model="amount" name="amount" placeholder="{{ __('tutor.withdraw_amount') }}" type="text" />
                                    <x-input-label for="maxamount" :value="__('tutor.max_limit')" />
                                    <span>{{ number_format((float) $balance * (float) getExchangeRate(), 2, ".", ",") }}</span>
                                </div>
                                <x-input-error field_name="amount" />
                            </div>
                            <div class="form-group am-form-btns">
                                <button wire:target="addWithdarwals" wire:loading.class="am-btn_disable" wire:click="addWithdarwals" type="button" class="am-btn">{{ __('tutor.save_update') }}</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-sidebar').toggleClass('am-togglesidebar');
        });
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-mainwrap').toggleClass('am-mainwrap_fullwidth');
        });
    });
</script>
