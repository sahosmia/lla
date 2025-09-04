@if(!empty(setting('_general.enable_multi_currency')))
    @if(!empty(setting('_general.multi_currency_list')))
        @php
            $currencies = currencyList();
            $selectedCurrency  = getCurrentCurrency();
        @endphp
        <form class="am-switch-language am-multi-currency" action="{{ route('switch-currency') }}" method="POST">
            @csrf
            <input type="hidden" name="am-currency">
            <div class="am-language-select am-currency-select">
                <a href="javascript:void(0);" class="am-currency-anchor">
                    {!! $selectedCurrency['code'] . '&nbsp;' . $selectedCurrency['symbol'] !!}<i class="am-icon-chevron-down"></i>
                </a>
                <ul class="sub-menutwo currency-menu">
                    @php
                        $baseCurrency       = setting('_general.base_currency') ?? 'USD';
                        $baseCurrencySymbol = $currencies[$baseCurrency]['symbol'] ?? '$';
                    @endphp
                    <li data-currency="{{ $baseCurrency }}" class="{{ $selectedCurrency['code'] == $baseCurrency ? 'active' : '' }}">
                        <span>{!! $baseCurrency . '&nbsp;' . $baseCurrencySymbol !!}</span>
                    </li>
                    @if(!empty(setting('_general.multi_currency_list')))
                        @foreach(setting('_general.multi_currency_list') as $currency)
                            <li data-currency="{!! $currency['code'] !!}" class="{{ $selectedCurrency['code'] == $currency['code'] ? 'active' : '' }}">
                                <span>{!! $currencies[$currency['code']]['code'] . '&nbsp;' . $currencies[$currency['code']]['symbol']  !!}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </form>
    @endif
@endif