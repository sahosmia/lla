<div class="am-dbbox am-payouthistory_wrap" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('tutor.payouts_history') }}</h2>
            <p>{{ __('tutor.payouts_dec') }}</p>
        </div>
    </div>
    @if($isLoading)
         @include('skeletons.payout')
    @else
        <div class="am-dbbox_content am-payouthistory">
            <div class="am-dbbox_title">
                <h2>{{ __('tutor.payouts_history') }}</h2>
                <div class="am-dbbox_title_sorting">
                    <em>{{ __('tutor.filter_by') }}</em>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="@this" data-live="true" class="am-select2" id="status"
                            data-wiremodel="status">
                            <option value="">{{ __('tutor.all') }}</option>
                            <option value="pending">{{ __('tutor.pending') }}</option>
                            <option value="declined">{{ __('tutor.declined') }}</option>
                            <option value="paid">{{ __('tutor.paid') }}</option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="am-payouttable">
                <table class="am-table @if(setting('_general.table_responsive') == 'yes') am-table-responsive @endif">
                    <thead>
                        <tr>
                            <th>{{ __('tutor.ref_no') }}</th>
                            <th>{{ __('tutor.method') }}</th>
                            <th>{{ __('tutor.date') }}</th>
                            <th>{{ __('tutor.amount') }}</th>
                            <th>{{ __('tutor.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$withdrawalDetails->isEmpty())
                            @foreach ($withdrawalDetails as $withdrawalDetail)
                            <tr>
                                <td data-label="{{ __('tutor.ref_no') }}">{{ $withdrawalDetail?->id }}</td>
                                <td data-label="{{ __('tutor.method') }}">{{ ucfirst($withdrawalDetail?->payout_method)
                                    }}</td>
                                <td data-label="{{ __('tutor.date') }}">{{
                                    $withdrawalDetail?->created_at?->format('m/d/Y') }}</td>
                                <td data-label="{{ __('tutor.amount') }}">{!! formatAmount($withdrawalDetail?->amount) !!}</td>
                                <td data-label="{{ __('tutor.status') }}">
                                    <span class="am-status">
                                        <em
                                            class="{{ $withdrawalDetail?->status == 'paid' ? 'am-status_paid' : 'am-status_declined'}}"></em>
                                        {{ ucfirst($withdrawalDetail?->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($withdrawalDetails->isEmpty())
            <x-no-record :image="asset('images/payouts.png')" :title="__('general.no_record_title')"
            :description="__('general.no_records_available')"  />
            @else
            {{ $withdrawalDetails->links('pagination.pagination') }}
            @endif
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
</script>
@endpush
