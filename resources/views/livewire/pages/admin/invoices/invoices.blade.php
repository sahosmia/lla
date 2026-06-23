<main class="tb-main am-dispute-system am-invoice-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.invoices') .' ('. $orders->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" {{ $status == '' ? 'selected' : '' }} >{{ __('invoices.all_invoices')  }}</option>
                                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }} >{{ __('booking.pending')  }}</option>
                                            <option value="complete" {{ $status == 'complete' ? 'selected' : '' }} >{{ __('booking.complete')  }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }} >{{ __('general.asc')  }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }} >{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if( !$orders->isEmpty() )
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <th>{{ __('booking.id') }}</th>
                                <th>{{ __('booking.transaction_id') }}</th>
                                <th>{{ __('booking.items') }}</th>
                                <th>{{ __('booking.student_name') }}</th>
                                <th>{{ __('booking.payment_method') }}</th>
                                <th>{{ __('booking.amount') }}</th>
                                <th>{{ __('booking.tutor_payout') }}</th>
                                <th>{{ __('booking.commission') }}</th>
                                @if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee')))
                                    <th>{{ setting('_platform_fee.platform_fee_title') }}</th>
                                @else
                                    <th>{{ __('booking.platform_fee') }}</th>
                                @endif
                                <th>{{ __('booking.status') }}</th>
                                <th>{{ __('general.actions') }}</th>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                       $options = $order?->options ?? [];
                                       $subject = $options['subject'] ?? '';
                                       $image   = $options['image'] ?? '';
                                    @endphp
                                    <tr>
                                        <td data-label="{{ __('booking.id') }}"><span>{{ $order?->id }}</span></td>
                                        <td data-label="{{ __('booking.transaction_id') }}"><span>{{ !empty($order?->transaction_id) ? $order->transaction_id : '-' }}</span></td>
                                        <td data-label="{{ __('booking.items' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img tb-adminhead__session">
                                                    @if(!empty($order?->slot_bookings_count))
                                                        {{ $order?->slot_bookings_count == 1 ? __('booking.session_count', ['count' => $order?->slot_bookings_count]) : __('booking.sessions_count', ['count' => $order?->slot_bookings_count]) }}
                                                    @endif
                                                    @if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && !empty($order?->courses_count) )
                                                        @if(!empty($order?->slot_bookings_count)) | @endif
                                                        {{ $order?->courses_count == 1 ? __('booking.course_count', ['count' => $order?->courses_count]) : __('booking.courses_count', ['count' => $order?->courses_count]) }}
                                                    @endif
                                                    @if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && !empty($order?->subscriptions_count))
                                                        @if(!empty($order?->slot_bookings_count) || !empty($order?->courses_count)) | @endif
                                                        {{ $order?->subscriptions_count == 1 ? __('booking.subscription_count', ['count' => $order?->subscriptions_count]) : __('booking.subscriptions_count', ['count' => $order?->subscriptions_count]) }}
                                                    @endif
                                                    @if(\Nwidart\Modules\Facades\Module::has('coursebundles') && \Nwidart\Modules\Facades\Module::isEnabled('coursebundles') && !empty($order?->coursebundles_count))
                                                        @if(!empty($order?->slot_bookings_count) || !empty($order?->courses_count) || !empty($order?->subscriptions_count)) | @endif
                                                        {{ $order?->coursebundles_count == 1 ? __('booking.coursebundle_count', ['count' => $order?->coursebundles_count]) : __('booking.coursebundles_count', ['count' => $order?->coursebundles_count]) }}
                                                    @endif
                                                </strong>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('booking.student_name' )}}">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($order?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->userProfile?->image))
                                                    <img src="{{ resizedImage($order?->userProfile?->image,34,34) }}" alt="{{$order?->userProfile?->image}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $order?->orderable?->student?->image }}" />
                                                    @endif
                                                </strong>
                                                <span>{{ $order?->userProfile?->full_name }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('booking.payment_method' )}}">
                                            <span>{{ __("settings." .$order?->payment_method. "_title")  }}</span>
                                        </td>
                                        <td data-label="{{ __('booking.amount') }}">
                                            <span>{!! formatAmount($order?->amount) !!}</span>
                                        </td>
                                        @php
                                            $firstItem      = $order?->items?->first();
                                            $commission     = is_numeric(getCommission($firstItem?->total)) ? getCommission($firstItem?->total) : 0;
                                            $options        = $firstItem?->options;
                                            $tutor_payout   = !empty($options['tutor_payout']) && is_numeric($options['tutor_payout']) ? $options['tutor_payout'] : ($firstItem?->total - $commission);
                                        @endphp
                                        <td data-label="{{ __('booking.tutor_payout') }}"><span>{{ formatAmount($tutor_payout) }}</span></td>
                                        <td data-label="{{ __('booking.commission') }}">
                                            <span>{!! empty($order?->subscription_id) ? formatAmount($order?->admin_commission) : formatAmount(0) !!}</span>
                                        </td>
                                        <td data-label="{{ __('booking.platform_fee') }}">
                                            @if( !empty($order?->items?->first()?->extra_fee))
                                                <span>{!! empty($order?->subscription_id) ? formatAmount($order?->items?->first()?->extra_fee) : formatAmount(0) !!}</span>
                                            @else
                                                <span>-</span>
                                            @endif  
                                        </td>
                                        <td data-label="{{ __('booking.status' )}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag  {{ $order?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ $order?->status}}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{__('general.actions')}}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-itemdropdown">
                                                        <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                        </a>
                                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a href="{{ route('download.invoice', $order?->id) }}" target="_blank">
                                                                    <i class="icon-download"></i>
                                                                    <span>{{ __('admin/general.pdf') }}</span>
                                                                </a>
                                                            </li>
                                                            <li wire:click.prevent="viewInvoice({{ $order?->id }})">
                                                                <i class="icon-eye"></i>
                                                                <span>{{ __('admin/general.preview') }}</span>
                                                            </li>
                                                        </ul>   
                                                    </div>  
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            {{ $orders->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Invoice detail Modal -->
    <div class="modal fade tb-invoice-detail-modal" data-bs-backdrop="static" id="invoicedetailwModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
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
                    <div class="tb-invoice-container">
                        <div class="tb-invoice-head">
                            <div class="tb-logo-invoicedetail">
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
                                <em>{{ $invoice?->updated_at->format(setting('_general.date_format')) ?? 'd M, Y' }}</em>
                            </li>
                            <li>
                                <h5>{{ __('invoices.transaction_id') }}</h5>
                                <em>{{ $invoice?->transaction_id ? $invoice?->transaction_id : '-' }}</em>
                            </li>
                        </ul>
                        @if(!empty($invoice?->items))
                            <div class="tb-invoice-items">
                                <div class="tb-items-header">
                                    <div class="tb-col tb-col-title">{{ __('invoices.items') }}</div>
                                    <div class="tb-col tb-col-qty">{{ __('invoices.invoice_qty') }}</div>
                                    <div class="tb-col tb-col-price">{{ __('invoices.invoice_price') }}</div>
                                    <div class="tb-col tb-col-tutorpayout">{{ __('booking.tutor_payout') }}</div>
                                    <div class="tb-col tb-col-admincommission">{{ __('booking.commission') }}</div>
                                    @if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee')))
                                        <div class="tb-col tb-col-platformfee">{{ setting('_platform_fee.platform_fee_title') }}</div>
                                    @else
                                        <div class="tb-col tb-col-platformfee">{{ __('booking.platform_fee') }}</div>
                                    @endif
                                    <div class="tb-col tb-col-discount">{{ __('invoices.amount') }}</div>
                                </div>
                    
                                <div class="tb-items-body">
                                    @foreach($invoice?->items as $item)
                                        @php
                                            $subTotal       = $subTotal + $item->price;
                                            $discountAmount = $discountAmount + $item?->discount_amount;
                                        @endphp
                                        <div class="tb-item-row">
                                            <div class="tb-col tb-col-title" data-label="{{ __('invoices.items') }}">
                                                {{ $item->title }}
                                                @if(!empty($item?->options['discount_code']))
                                                <span>Code: #{{$item?->options['discount_code'] }}</span> 
                                               @endif
                                            </div>
                                            <div class="tb-col tb-col-qty" data-label="{{ __('invoices.invoice_qty') }}">{{ $item->quantity }}</div>
                                            <div class="tb-col tb-col-price" data-label="{{ __('invoices.invoice_price') }}">
                                                @if(!empty($item?->discount_amount))
                                                    <em>{{ formatAmount($item->price) }}</em>
                                                    {{ formatAmount($item->total) }}
                                                @else     
                                                    {{ !empty($item->extra_fee) ? formatAmount($item->price + $item->extra_fee) : formatAmount($item->price) }}
                                                @endif
                                            </div>
                                            @php
                                                $commission     = is_numeric(getCommission($item->total)) ? getCommission($item->total) : 0;
                                                $tutor_payout   = !empty($item->options['tutor_payout']) && is_numeric($item->options['tutor_payout']) ? $item->options['tutor_payout'] : ($item->total - $commission);
                                            @endphp
                                            <div class="tb-col tb-col-tutorpayout" data-label="{{ __('booking.tutor_payout') }}">{{ formatAmount($tutor_payout) }}</div>
                                            <div class="tb-col tb-col-admincommission" data-label="{{ __('booking.commission') }}">{{ formatAmount($item->platform_fee) }}</div>
                                            <div class="tb-col tb-col-platformfee" data-label="{{ __('booking.platform_fee') }}">
                                              {{ !empty($item->extra_fee) ? formatAmount($item->extra_fee) : '-' }}
                                            </div>
                                            <div class="tb-col tb-col-discount" data-label="{{ __('invoices.amount') }}">{{ formatAmount($item->total) }}</div>
                                        </div>
                                    @endforeach
                                    <div class="tb-item-row tb-item-subtotal">
                                        <div class="tb-col tb-col-title"><strong>{{ __('invoices.invoice_subtotal') }}</strong></div>
                                        <div class="tb-col tb-col-qty"></div>
                                        <div class="tb-col tb-col-price" ></div>
                                        <div class="tb-col tb-col-tutorpayout"></div>
                                        <div class="tb-col tb-col-admincommission"></div>
                                        <div class="tb-col tb-col-platformfee"></div>
                                        <div class="tb-col tb-col-discount">{{ formatAmount($subTotal) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tb-invoice-summary">
                            <h6>{{ __('invoices.invoice_summary') }}</h6>
                            @php
                                $grossTotal = 0;
                                if($invoice?->items) {
                                    foreach($invoice?->items as $item) {
                                        $grossTotal += ( $item?->price - $item?->discount_amount ?? 0) * $item->quantity;
                                    }
                                }
                            @endphp
                            <div class="tb-summary-row">
                                <span class="tb-label" data-label="Subtotal">{{ __('invoices.invoice_subtotal') }}:</span>
                                <span class="tb-value">{{ formatAmount($subTotal) }}</span>
                            </div>
                            @if($discountAmount > 0)
                                <div class="tb-summary-row">
                                    <span class="tb-label" data-label="Total">{{ __('invoices.invoice_discount_amount') }}</span>
                                    <span class="tb-value">{{formatAmount($discountAmount) }}</span>
                                </div>
                            @endif
                            <div class="tb-summary-row">
                                <span class="tb-label" data-label="Total">{{ __('invoices.grand_total') }}</span>
                                <span class="tb-value">{{ formatAmount($grossTotal) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ isset($invoice->id) ? route('download.invoice', $invoice->id) : '#' }}">
                        <button type="button" class="tb-btn">{{ __('invoices.download_pdf') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Invoice detail Modal -->
</main>


@push('scripts')
    <script>
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