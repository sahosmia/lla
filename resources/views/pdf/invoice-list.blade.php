<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap');
        /* Reset box-sizing for PDF compatibility */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        /* Clearfix for floated elements */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="tb-invoice-detail-modal">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 700px; margin: 0 auto;">
            <div class="modal-content" style="padding: 0;">
                <div class="modal-header" style="padding: 20px 30px 18px; border-bottom: 1px solid #EAEAEA;">
                    <h5 class="modal-title" style="color: rgba(0, 0, 0, 0.7); font-weight: 600; font-family: 'Roboto', sans-serif; font-size: 18px; line-height: 20px; margin: 0;">{{ __('invoices.invoice') }}</h5>
                    <span class="am-closepopup" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px; width: 36px; height: 36px; display: inline-block; text-align: center; border-radius: 10px; cursor: pointer;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g opacity="0.7">
                            <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>
                    </span>
                </div>
                @php
                    $subTotal = 0;
                    $discountAmount = 0; 
                @endphp
                <div class="modal-body" style="padding: 0;">
                    <div class="tb-invoice-container" style="padding: 16px 30px;">
                        <div class="tb-invoice-head clearfix" style="margin-bottom: 20px;">
                            <div class="tb-logo-invoicedetail" style="width: 100%;">
                                <strong style="display: inline-block; vertical-align: middle;">
                                    <a href="#">
                                        <img src="{{ $company_logo }}" alt="{{ $company_name }}" style="max-width: 150px; height: auto;"/>
                                    </a>
                                </strong>
                                <span style="display: inline-block; vertical-align: middle; float: right; color: #585858; font-weight: 600; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px; margin-top: 9px;">{{ __('invoices.invoice_id') }} #{{ $invoice?->id }}</span>
                            </div>
                        </div>
                        <ul class="am-payment-to-from clearfix" style="width: 100%; margin: 40px 0 0 0; padding: 0; list-style: none;">
                            <li style="width: 48%; display: inline-block; vertical-align: top;">
                                <strong style="color: #585858; font-weight: 600; font-family: 'Roboto', sans-serif; font-size: 14px; opacity: 0.7; line-height: 20px;">Company</strong>
                                <h6 style="color: #000; font-family: 'Roboto', sans-serif; font-size: 14px; font-weight: 400; margin: 10px 0 0 0; line-height: 20px;">
                                    {{ $company_name }}
                                    <em style="display: block; color: #585858; font-family: 'Roboto', sans-serif; font-size: 12px; font-weight: 400; opacity:0.9; line-height: 18px; font-style: normal;">{{ $company_email }}</em>
                                </h6>
                                <p style="color: #585858; font-family: 'Roboto', sans-serif; font-size: 12px; font-weight: 400; margin: 10px 0 0 0; line-height: 18px; opacity: 0.9;">{{ $company_address }}</p>
                            </li>
                            <li style="width: 48%; display: inline-block; vertical-align: top; float: right;">
                                <strong style="color: #585858; font-weight: 600; font-family: 'Roboto', sans-serif; font-size: 14px; opacity: 0.7; line-height: 20px;">{{ __('invoices.payment_from') }}</strong>
                                <h6 style="color: #000; font-family: 'Roboto', sans-serif; font-size: 14px; font-weight: 400; margin: 10px 0 0 0; line-height: 20px;">
                                    {{ $invoice?->first_name }} {{ $invoice?->last_name }}
                                    <em style="display: block; color: #585858; font-family: 'Roboto', sans-serif; font-size: 12px; font-weight: 400; opacity:0.9; line-height: 18px; font-style: normal;">{{ $invoice?->email }}</em>
                                </h6>
                                <p style="color: #585858; font-family: 'Roboto', sans-serif; font-size: 12px; font-weight: 400; margin: 10px 0 0 0; line-height: 18px; opacity: 0.9;"> {{ $invoice?->city }}, {{ $invoice?->countryDetails?->name ?? '' }}, {{ $invoice?->state }}</p>
                            </li>
                        </ul>
                        <ul class="am-payment-to-from clearfix" style="width: 100%; margin: 15px 0 0 0; padding: 16px 0 0 0; list-style: none; border-top: 1px solid #EAEAEA;">
                            <li style="width: 48%; display: inline-block; vertical-align: top;">
                                <h5 style="margin: 0; color: #585858; font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 18px;">{{ __('invoices.payment_date') }}</h5>
                                <em style="display: block; font-style: normal; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px; margin-top: 10px;">{{ $invoice?->created_at->format(setting('_general.date_format')) ?? 'd M, Y' }}</em>
                            </li>
                            <li style="width: 48%; display: inline-block; vertical-align: top; float: right;">
                                <h5 style="margin: 0; color: #585858; font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 18px;">{{ __('invoices.transaction_id') }}</h5>
                                <em style="display: block; font-style: normal; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px; margin-top: 10px;">{{ $invoice?->transaction_id ? $invoice?->transaction_id : '-' }}</em>
                            </li>
                        </ul>
                        @if(!empty($invoice?->items))
                            <div class="tb-invoice-items" style="margin-top: 18px; width: 100%;">
                                <div class="tb-items-header" style="background: #f8f9fa; padding: 15px; font-weight: 600; border-radius: 10px;">
                                    <div class="tb-col tb-col-title" style="width: 22%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('invoices.items') }}</div>
                                    @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'student')
                                        <div class="tb-col tb-col-empty" style="width: 26%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                    @endif
                                    <!-- @if(auth()->user()->role == 'student')
                                        <div class="tb-col tb-col-empty" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                    @endif -->
                                    <div class="tb-col tb-col-qty" style="width: 10%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('invoices.invoice_qty') }}</div>
                                    <div class="tb-col tb-col-price" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('invoices.invoice_price') }}</div>
                                    @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'admin')
                                        <div class="tb-col tb-col-discount" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ auth()->user()->role == 'tutor' ? __('booking.net_payout') : __('booking.tutor_payout') }}</div>
                                    @endif
                                    @if(auth()->user()->role == 'admin')
                                        <div class="tb-col tb-col-commission" style="width: 16%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('booking.commission') }}</div>
                                    @endif
                                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'student')
                                        <div class="tb-col tb-col-platform_fee" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('booking.platform_fee') }}</div>
                                    @endif
                                    <div class="tb-col tb-col-discount" style="width: 12%; display: inline-block; vertical-align: top; text-align: right; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('invoices.amount') }}</div>
                                </div>
                    
                                <div class="tb-items-body">
                                    @foreach($invoice?->items as $item)
                                        @php
                                            $subTotal       = $subTotal + $item->price;
                                            $discountAmount = $discountAmount + $item?->discount_amount;
                                        @endphp
                                        <div class="tb-item-row" style="border-bottom: 1px solid #eee; padding: 14px 20px; overflow: hidden;">
                                            <div class="tb-col tb-col-title" data-label="{{ __('invoices.items') }}" style="width: 22%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">
                                                {{ $item->title }}
                                                @if(!empty($item?->options['discount_code']))
                                                    <span style="margin-top: 2px; display: block; color: rgba($text-light, 0.9); font: 400 rem(12)/em(120%,12) $heading-font-family;">Code: #{{$item?->options['discount_code'] }}</span> 
                                                @endif
                                            </div>
                                            @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'student')
                                                <div class="tb-col tb-col-empty" style="width: 26%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                            @endif
                                            <!-- @if(auth()->user()->role == 'student')
                                                <div class="tb-col tb-col-empty" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                            @endif -->
                                            <div class="tb-col tb-col-qty" data-label="{{ __('invoices.invoice_price') }}" style="width: 10%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ $item->quantity}}</div>
                                            <div class="tb-col tb-col-price" data-label="{{ __('invoices.invoice_price') }}" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">
                                                @if(!empty($item?->discount_amount))
                                                    <del style="color: rgba(#585858, 0.9); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 12px; line-height: 14px;">{{ formatAmount($item->price) }}</del>
                                                    {{ formatAmount($item->total) }}
                                                @else     
                                                    @if(auth()->user()->role == 'student' || auth()->user()->role == 'admin')
                                                        {{ !empty($item->extra_fee) ? formatAmount($item->price + $item->extra_fee) : formatAmount($item->price) }}
                                                    @else
                                                        {{ formatAmount($item->price) }}
                                                    @endif
                                                @endif
                                            </div>
                                            @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'admin')
                                                @php
                                                    $commission     = is_numeric(getCommission($item->total)) ? getCommission($item->total) : 0;
                                                    $tutor_payout   = !empty($item->options['tutor_payout']) && is_numeric($item->options['tutor_payout']) ? $item->options['tutor_payout'] : ($item->total - $commission);
                                                @endphp
                                                <div class="tb-col tb-col-netpay" data-label="{{ auth()->user()->role == 'tutor' ? __('booking.net_payout') : __('booking.tutor_payout') }}" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ formatAmount($tutor_payout) }}</div>
                                            @endif
                                            @if(auth()->user()->role == 'admin')
                                                <div class="tb-col tb-col-commission" data-label="{{ __('booking.commission') }}" style="width: 16%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ formatAmount($item->platform_fee) }}</div>
                                            @endif
                                            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'student')
                                                <div class="tb-col tb-col-platform_fee" data-label="{{ __('booking.platform_fee') }}" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ !empty($item->extra_fee) ? formatAmount($item->extra_fee) : '-' }}</div>
                                            @endif
                                            <div class="tb-col tb-col-discount" data-label="{{ __('invoices.invoice_subtotal') }}" style="width: 12%; display: inline-block; vertical-align: top; text-align: right; color: rgba(0, 0, 0, 0.7); font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ formatAmount($item->total) }}</div>
                                        </div>
                                    @endforeach
                                    <div class="tb-item-row" style=" padding: 14px 20px;">
                                        <div class="tb-col tb-col-title" style="width: 26%; display: inline-block; vertical-align: top; text-align: left; color: rgba(0, 0, 0, 0.7); font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"><strong style="font-weight: 600;">{{ __('invoices.invoice_subtotal') }}</strong></div>
                                        @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'student')
                                            <div class="tb-col tb-col-empty" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        @endif
                                        @if(auth()->user()->role == 'student')
                                            <div class="tb-col tb-col-empty" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        @endif
                                        <div class="tb-col tb-col-price" style="width: 10%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        <div class="tb-col tb-col-price" style="width: 12%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        @if(auth()->user()->role == 'admin')
                                            <div class="tb-col tb-col-commission" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        @endif
                                        @if(auth()->user()->role == 'tutor' || auth()->user()->role == 'admin')
                                            <div class="tb-col tb-col-netpay" style="width: 18%; display: inline-block; vertical-align: top; text-align: left; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"></div>
                                        @endif
                                        <div class="tb-col tb-col-qty" style="width: 12%; display: inline-block; vertical-align: top; text-align: right; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;"><strong style="font-weight: 600;">{{ formatAmount($subTotal) }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tb-invoice-summary" style="width: 250px; margin-top: 20px; padding: 10px; border-radius: 8px; background: #F7F7F8; margin-left: auto; margin-right: 10px;">
                            <h6 style="color: #585858; margin: 0 0 10px 0; font-weight: 600; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ __('invoices.invoice_summary') }}</h6>
                            @php
                                $grossTotal = 0;
                                if($invoice?->items) {
                                    foreach($invoice?->items as $item) {
                                        $grossTotal += ( $item?->price - $item?->discount_amount ?? 0) * $item->quantity;
                                    }
                                }
                            @endphp
                            <div class="tb-summary-row" style="display: table; width: 100%; font-family: 'Roboto', sans-serif; font-size: 15px;">
                                <span class="tb-label" style="display: table-cell; color: #585858; font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 13px; line-height: 18px;" data-label="Subtotal">{{ __('invoices.invoice_subtotal') }}:</span>
                                <span class="tb-value" style="display: table-cell; text-align: right; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ formatAmount($subTotal) }}</span>
                            </div>
                            @if($discountAmount > 0)
                                <div class="tb-summary-row" style="display: table; width: 100%; margin-top: 10px; font-family: 'Roboto', sans-serif; font-size: 15px;">
                                    <span class="tb-label" style="display: table-cell; color: #585858; font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 13px; line-height: 18px;" data-label="Total">{{ __('invoices.invoice_discount_amount') }}</span>
                                    <span class="tb-value" style="display: table-cell; text-align: right; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{formatAmount($discountAmount) }}</span>
                                </div>
                            @endif
                            <div class="tb-summary-row" style="display: table; width: 100%; margin-top: 10px; font-family: 'Roboto', sans-serif; font-size: 15px;">
                                <span class="tb-label" style="display: table-cell; color: #585858; font-weight: 400; font-family: 'Roboto', sans-serif; font-size: 13px; line-height: 18px;" data-label="Total">{{ __('invoices.grand_total') }}</span>
                                <span class="tb-value" style="display: table-cell; text-align: right; color: #585858; font-weight: 500; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 20px;">{{ formatAmount($grossTotal) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>