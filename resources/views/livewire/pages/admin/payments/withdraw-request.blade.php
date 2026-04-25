<main class="tb-main am-dispute-system>
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('general.all_requests') .' ('. $requests->total() .')' }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="filter_request" data-wiremodel="filter_request">
                                            <option value =""> {{ __('general.all') }} </option>
                                            <option value ="pending"> {{ __('general.pending') }} </option>
                                            <option value ="processed"> {{ __('general.processed_payment') }} </option>
                                            <option value ="complete"> {{ __('general.completed') }} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="sortby" data-wiremodel="sortby">
                                            <option value="asc">{{ __('general.asc')  }}</option>
                                            <option value="desc">{{ __('general.desc')  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="per_page" data-wiremodel="per_page">
                                            @foreach($per_page_opt as $opt )
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_request"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if( !$requests->isEmpty() )
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>{{ __('#' )}}</th>
                                    <th>{{ __( 'general.name' )}}</th>
                                    <th>{{ __('general.date' )}}</th>
                                    <th>{{ __('general.withdraw_amount' )}}</th>
                                    <th>{{ __('general.payout_type' )}}</th>
                                    <th>{{__('general.status')}}</th>
                                    <th>{{ __('general.account_detail' )}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $single)
                                    <tr>
                                        <td data-label="{{ __('#' )}}"><span>{{ $single->id }}</span></td>
                                        <td data-label="{{ __( 'general.name' )}}"><span>{!! $single->User->full_name !!}</span></td>
                                        <td data-label="{{ __('general.date' )}}"><span>{{ date($date_format, strtotime( $single->created_at )) }}</span></td>
                                        <td data-label="{{ __('general.withdraw_amount' )}}"><span>{{ formatAmount($single->amount) }}</span></td>
                                        <td data-label="{{ __('general.payout_type' )}}">
                                            @if($single->payout_method == 'escrow')
                                                <span>{{ __('billing_info.escrow') }}</span>
                                            @elseif($single->payout_method == 'paypal')
                                                <span>{{ __('billing_info.paypal') }}</span>
                                            @elseif($single->payout_method == 'payoneer')
                                                <span>{{ __('billing_info.payoneer') }}</span>
                                            @elseif($single->payout_method == 'bank')
                                                <span>{{ __('billing_info.bank') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{__('general.status')}}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag {{ $single->status == 'pending' ? 'tk-fixed-tag' : 'tk-hourly-tag' }}">{{ $single?->status }}</em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.account_detail' )}}">
                                            <ul class="tb-action-status">
                                                <li>
                                                    @if( $single->status == 'pending' )
                                                    <span class="tb-unapproved">
                                                        <a href="javascript:;"  @click="$wire.dispatch('showConfirm', { id : {{ $single->id }}, action : 'approve-request' })"><i class="fas fa-check"></i>{{ __('general.approve') }}</a>
                                                    </span>
                                                    @else
                                                        <span class="tb-approved"><i class="fas fa-check"></i>{{ __('general.approved') }}</span>
                                                    @endif
                                                </li>
                                                <li>
                                                    <a href="javascript:;" wire:click.prevent="accountInfo({{$single->id}})" target="_blank" ><i class="icon-eye"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $requests->links('pagination.custom') }}
                    @else
                    <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade tb-addonpopup" id="account-info-modal"  data-bs-backdrop="static">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    @if( $payment_method == 'escrow' )
                        <h4> {{ __('billing_info.escrow_acc_info') }} </h4>
                    @elseif( $payment_method == 'paypal' )
                        <h4> {{ __('billing_info.paypal_info') }} </h4>
                    @elseif( $payment_method == 'payoneer' )
                        <h4> {{ __('billing_info.payoneer_acc_info') }} </h4>
                    @elseif( $payment_method == 'bank'  )
                        <h4> {{ __('billing_info.bank_acc_info') }} </h4>
                    @endif
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <ul class="tb-userinfo">

                        @if( $payment_method == 'escrow' )
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info['escrow_email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'paypal' )
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info[0]['email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'payoneer'  )
                            <li>
                                <span>{{ __('general.email') }}:</span>
                                <h6>{{ $account_info[0]['email'] }}</h6>
                            </li>
                        @elseif( $payment_method == 'bank' )
                            <li>
                                <span>{{ __('billing_info.account_title') }}:</span>
                                <h6>{{ $account_info['title'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.account_number') }}:</span>
                                <h6>{{ $account_info['account_number'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_name') }}:</span>
                                <h6>{{ $account_info['bank_name'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.routing_number') }}:</span>
                                <h6>{{ $account_info['bank_routing_number'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_iban') }}:</span>
                                <h6>{{ $account_info['bank_iban'] }}</h6>
                            </li>
                            <li>
                                <span>{{ __('billing_info.bank_bic_swift') }}:</span>
                                <h6>{{ $account_info['bank_btc'] }}</h6>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<Script>
    document.addEventListener('openModal', (e) => {
        setTimeout(() => {
            $('#account-info-modal').modal('show');
        }, 500);
    });
</Script>
