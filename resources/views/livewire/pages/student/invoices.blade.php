<div class="am-dbbox am-invoicelist_wrap am-dispute-system" wire:init="loadData">
    @if($isLoading)
        @include('skeletons.invoices')
    @else
        <div class="am-dbbox_content am-invoicelist">
            <div class="am-dbbox_title">
                @slot('title')
                    {{ __('invoices.invoices') }}
                @endslot
                <h2>{{ __('invoices.invoices') }}</h2>
                <div class="am-dbbox_title_sorting">
                    <em>{{ __('invoices.filter_by') }}</em>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="@this" data-live="true" class="am-select2" id="status"
                            data-wiremodel="status">
                            <option value="" {{ $status == '' ? 'selected' : '' }}>{{ __('invoices.all_invoices') }}</option>
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('invoices.pending') }}</option>
                            <option value="complete" {{ $status == 'complete' ? 'selected' : '' }}>{{ __('invoices.complete') }}</option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <table class="am-table @if(setting('_general.table_responsive') == 'yes') am-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('booking.id') }}</th>
                                <th>{{ __('booking.date') }}</th>
                                <th>{{ __('booking.transaction_id') }}</th>
                                <th>{{ __('general.item' )}}</th>
                                @if(auth()->user()->role == 'tutor')
                                    <th>{{ __('booking.student_name') }}</th>
                                    <th>{{ __('booking.amount') }}</th>
                                    <th>{{ __('booking.net_payout') }}</th>
                                @elseif(auth()->user()->role == 'student')
                                    <th>{{ __('booking.tutor_name') }}</th>
                                    <th>{{ __('booking.amount') }}</th>
                                    @if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee')))
                                        <th>{{ setting('_platform_fee.platform_fee_title') }}</th>
                                    @else
                                        <th>{{ __('booking.platform_fee') }}</th>
                                    @endif
                                @endif
                                <th>
                                    <div class="am-status-action">
                                        <span>{{ __('booking.status') }}</span>
                                        <span>{{ __('booking.action') }}</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$orders->isEmpty())
                                @foreach($orders as $order)
                                    @php
                                        $options        = $order?->options;
                                        $subject        = !empty($options['subject']) ? $options['subject'] : '';
                                        $image          = !empty($options['image']) ? $options['image'] : '';
                                        $subjectGroup   = !empty($options['subject_group']) ? $options['subject_group'] : '';
                                        $orderTotal     = is_numeric($order?->total) ? $order?->total : 0;
                                        $commission     = is_numeric(getCommission($orderTotal)) ? getCommission($orderTotal) : 0;
                                        $tutor_payout   = !empty($options['tutor_payout']) && is_numeric($options['tutor_payout']) ? $options['tutor_payout'] : ($orderTotal - $commission);
                                    @endphp
                                    <tr>
                                        <td data-label="{{ __('booking.id') }}"><span>{{ $order?->order_id }}</span></td>
                                        <td data-label="{{ __('booking.date') }}"><span>{{ $order?->created_at->format('F j, Y') }}</span></td>
                                        <td data-label="{{ __('booking.transaction_id') }}"><span>{{ !empty($order?->orders?->transaction_id) ? $order?->orders?->transaction_id : '-' }}</span></td>
                                        <td data-label="{{ __('general.item' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($image) && Storage::disk(getStorageDisk())->exists($image))
                                                        <img src="{{ resizedImage($image,34,34) }}" alt="{{$image}}" />
                                                    @else
                                                        <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $image }}" />
                                                    @endif
                                                </strong>
                                                @if($order->orderable_type == App\Models\SlotBooking::class)
                                                    <span>{{ $subject  }}<small>{{ $subjectGroup }}</small></span>
                                                @elseif($order->orderable_type == \Modules\Courses\Models\Course::class && !empty($options['title']))
                                                    <span>{{ $options['title'] }}</span>
                                                @elseif(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && $order->orderable_type == 'Modules\Subscriptions\Models\Subscription')
                                                    <span>{{ $order->options['name'] }} <small>{{ __($order->options['period']) }}</small></span>
                                                @elseif(\Nwidart\Modules\Facades\Module::has('courseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('courseBundles') && $order->orderable_type == 'Modules\CourseBundles\Models\Bundle')
                                                    <span>{{ $order->options['title'] }}</span>    
                                                @endif
                                            </div>
                                        </td>
                                        @if(auth()->user()->role == 'student')
                                            <td data-label="{{ __('booking.tutor_name' )}}">
                                                <div class="tb-varification_userinfo">
                                                    @if($order?->orderable_type == \Modules\Courses\Models\Course::class)
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orderable?->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor?->profile?->image))
                                                            <img src="{{ resizedImage($order?->orderable?->instructor?->profile?->image,34,34) }}" alt="{{$order?->orderable?->instructor?->profile?->image}}" />
                                                            @else
                                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->instructor?->profile?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orderable?->instructor?->profile?->first_name }}</span>
                                                    @elseif($order?->orderable_type == App\Models\SlotBooking::class)
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orderable?->tutor?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->tutor?->image))
                                                            <img src="{{ resizedImage($order?->orderable?->tutor?->image,34,34) }}" alt="{{$order?->orderable?->tutor?->image}}" />
                                                            @else
                                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->tutor?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orderable?->tutor?->first_name }}</span>
                                                    @elseif($order?->orderable_type == \Modules\CourseBundles\Models\Bundle::class)
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orderable?->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor?->profile?->image))
                                                            <img src="{{ resizedImage($order?->orderable?->instructor?->profile?->image,34,34) }}" alt="{{$order?->orderable?->instructor?->profile?->image}}" />
                                                            @else
                                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->instructor?->profile?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orderable?->instructor?->profile?->first_name }}</span>    
                                                    @else
                                                        <span>-</span>    
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-label="{{ __('booking.amount') }}">
                                                <span>{!! formatAmount($order?->orders?->amount) !!}</span>
                                            </td>
                                            <td data-label="{{ __('booking.platform_fee') }}">
                                                <span>{!! !empty($order?->extra_fee) ? formatAmount($order?->extra_fee) : '-' !!}</span>
                                            </td>
                                        @elseif(auth()->user()->role == 'tutor')
                                            <td data-label="{{ __('booking.student_name' )}}">
                                                <div class="tb-varification_userinfo">
                                                    @if($order->orderable_type != 'Modules\Subscriptions\Models\Subscription')
                                                        <strong class="tb-adminhead__img">
                                                            @if (!empty($order?->orders?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->orders?->userProfile?->image))
                                                            <img src="{{ resizedImage($order?->orders?->userProfile?->image,34,34) }}" alt="{{$order?->orders?->userProfile?->image}}" />
                                                            @else
                                                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->student?->image }}" />
                                                            @endif
                                                        </strong>
                                                        <span>{{ $order?->orders?->userProfile?->first_name }}</span>
                                                    @else
                                                        <span>-</span> 
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-label="{{ __('booking.amount') }}">
                                                <span>{!! formatAmount($order?->total) !!}</span>
                                            </td>
                                            <td data-label="{{ __('booking.net_payout') }}">
                                                @if ($order->orderable_type != 'Modules\Subscriptions\Models\Subscription')
                                                    <span>{!! formatAmount($tutor_payout) !!}</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td data-label="{{ __('booking.status' )}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag-two {{ $order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $order?->orders?->status}}</em>
                                            </div>
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-itemdropdown">
                                                        <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                        </a>
                                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a href="{{ route('download.invoice', $order?->order_id) }}" target="_blank">
                                                                    <i class="am-icon-download-01"></i>
                                                                    <span>{{ __('invoices.pdf') }}</span>
                                                                </a>
                                                            </li>
                                                            <li >
                                                                <a href="#" wire:click.prevent="viewInvoice({{ $order?->order_id }})">
                                                                    <i class="am-icon-eye-open-01"></i>
                                                                    <span>{{ __('invoices.preview') }}</span>
                                                                </a>
                                                            </li>
                                                        </ul>   
                                                    </div>  
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if ($orders->isEmpty())
                    <x-no-record :image="asset('images/payouts.png')" :title="__('general.no_record_title')"
                    :description="__('general.no_records_available')"  />
                    @else
                </div>
            </div>
            {{ $orders->links('pagination.pagination') }}
            @endif
        </div>
    @endif
    @if(!empty($invoice))
        <div class="modal fade am-invoice-detail-modal" data-bs-backdrop="static" id="invoicedetailwModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('invoices.invoice') }}</h5>
                        <span class="am-closepopup" data-bs-dismiss="modal" aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <g opacity="0.7">
                                <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <div class="modal-body">
                        <div class="am-invoice-container">
                            <div class="am-invoice-head">
                                <div class="am-logo-invoicedetail">
                                    <strong>
                                        <a href="#">
                                            <img src="{{ $company_logo }}" alt="{{ $company_name }}" />
                                        </a>
                                    </strong>
                                    <span>{{ __('invoices.invoice_id') }} #{{ $invoice?->id }}</span>
                                </div>
                            </div>
                            <ul class="am-payment-to-from">
                                <li>
                                    <strong>{{ __('invoices.company') }}</strong>
                                    <h6>
                                        {{ $company_name }}
                                        <em>{{ $company_email }}</em>
                                    </h6>
                                    <p>{{ $company_address }}</p>
                                </li>
                                <li>
                                    <strong>{{ __('invoices.payment_from') }}</strong>
                                    <h6>
                                        {{ $invoice?->first_name }} {{ $invoice?->last_name }}
                                        <em>{{ $invoice?->email }}</em>
                                    </h6>
                                    <p> {{ $invoice?->city }}, {{ $invoice?->countryDetails?->name ?? '' }}, {{ $invoice?->state }}</p>
                                </li>
                            </ul>
                            <ul class="am-payment-to-from">
                                <li>
                                    <h5>{{ __('invoices.payment_date') }}</h5>
                                    <em>{{ $invoice?->created_at->format(setting('_general.date_format')) ?? 'd M, Y' }}</em>
                                </li>
                                <li>
                                    <h5>{{ __('invoices.transaction_id') }}</h5>
                                    <em>{{ $invoice?->transaction_id ? $invoice?->transaction_id : '-' }}</em>
                                </li>
                            </ul>
                            <div class="am-invoice-items">
                                <div class="am-items-header">
                                    <div class="am-col am-col-title">{{ __('invoices.items') }}</div>
                                    <div class="am-col am-col-qty">{{ __('invoices.invoice_qty') }}</div>
                                    <div class="am-col am-col-price">{{ __('invoices.invoice_price') }}</div>
                                    @if(auth()->user()->role == 'tutor')
                                        <div class="am-col am-col-netpay">{{ __('booking.net_payout') }}</div>
                                    @endif
                                    @if(auth()->user()->role == 'student')
                                        @if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee')))
                                            <div class="am-col am-col-platform_fee">{{ setting('_platform_fee.platform_fee_title') }}</div>
                                        @else
                                            <div class="am-col am-col-platform_fee">{{ __('booking.platform_fee') }}</div>
                                        @endif
                                    @endif
                                    <div class="am-col am-col-discount">{{ __('invoices.amount') }}</div>
                                </div>
                                <div class="am-items-body">
                                    @if(isset($invoice) && $invoice->items)
                                        @foreach($invoice->items as $item)
                                            @php
                                                $subTotal       = $subTotal + $item->price;
                                                $discountAmount = $discountAmount + $item?->discount_amount;
                                            @endphp
                                            <div class="am-item-row">
                                                <div class="am-col am-col-title" data-label="{{ __('invoices.items') }}">
                                                    {{ $item->title }}
                                                    @if(!empty($item?->options['discount_code']))
                                                        <span>Code: #{{$item?->options['discount_code'] }}</span> 
                                                    @endif
                                                </div>
                                                <div class="am-col am-col-qty" data-label="{{ __('invoices.invoice_qty') }}">{{ $item->quantity }}</div>
                                                <div class="am-col am-col-price" data-label="{{ __('invoices.invoice_price') }}">
                                                    @if(!empty($item?->discount_amount))
                                                        <em>{{ formatAmount($item->price) }}</em>
                                                        {{ formatAmount($item->total) }}
                                                    @else     
                                                        {{ !empty($item->extra_fee) && (auth()->user()->role == 'student') ? formatAmount($item->price + $item->extra_fee) : formatAmount($item->price) }}
                                                    @endif
                                                </div>
                                                @if(auth()->user()->role == 'tutor')
                                                    @php
                                                        $commission     = is_numeric(getCommission($item->total)) ? getCommission($item->total) : 0;
                                                        $tutor_payout   = !empty($item->options['tutor_payout']) && is_numeric($item->options['tutor_payout']) ? $item->options['tutor_payout'] : ($item->total - $commission);
                                                    @endphp
                                                    <div class="am-col am-col-netpay" data-label="{{ __('booking.net_payout') }}">{{ formatAmount($tutor_payout) }}</div>
                                                @endif
                                                @if(auth()->user()->role == 'student')
                                                    <div class="am-col am-col-platform_fee" data-label="{{ __('booking.platform_fee') }}">{{ !empty($item->extra_fee) ? formatAmount($item->extra_fee) : '-' }}</div>
                                                @endif
                                                <div class="am-col am-col-discount" data-label="{{ __('invoices.amount') }}">{{ formatAmount($item->total) }}</div>
                                            </div>
                                        @endforeach
                                        <div class="am-item-row am-item-subtotal">
                                            <div class="am-col am-col-title"><strong>{{ __('invoices.invoice_subtotal') }}</strong></div>
                                            <div class="am-col am-col-qty"></div>
                                            <div class="am-col am-col-price" ></div>
                                            @if(auth()->user()->role == 'tutor')
                                                <div class="am-col am-col-netpay"></div>
                                            @endif
                                            <div class="am-col am-col-discount"><strong>{{ formatAmount($subTotal) }}</strong></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="am-invoice-summary">
                                <h6>{{ __('invoices.invoice_summary') }}</h6>
                                @php
                                    $grossTotal = 0;
                                    if($invoice?->items) {
                                        foreach($invoice?->items as $item) {
                                            $grossTotal += ( $item?->price - $item?->discount_amount ?? 0) * $item->quantity;
                                        }
                                    }
                                @endphp
                                <div class="am-summary-row">
                                    <span class="am-label" data-label="Subtotal">{{ __('invoices.invoice_subtotal') }}:</span>
                                    <span class="am-value">{{ formatAmount($subTotal) }}</span>
                                </div>
                                @if($discountAmount > 0)
                                    <div class="am-summary-row">
                                        <span class="am-label" data-label="Total">{{ __('invoices.invoice_discount_amount') }}</span>
                                        <span class="am-value">{{formatAmount($discountAmount) }}</span>
                                    </div>
                                @endif
                                <div class="am-summary-row">
                                    <span class="am-label" data-label="Total">{{ __('invoices.grand_total') }}</span>
                                    <span class="am-value">{{ formatAmount($grossTotal) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ isset($invoice->id) ? route('download.invoice', $invoice->id) : '#' }}">
                            <button type="button" class="am-btn">{{ __('invoices.download_pdf') }}</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts' )
<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
            component = @this;
    },{ once: true });
    document.addEventListener('loadPageJs', (event) => {
        component.dispatch('initSelect2', {target:'.am-select2'});
    })
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('openInvoiceModal', function(event) {
            setTimeout(() => {
                $('#invoicePreviewModal').modal('show');
                $('#invoicedetailwModal').modal('show');
            }, 500);
        });
    });
</script>
@endpush
