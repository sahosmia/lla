<div class="am-dbbox am-invoicelist_wrap">
    <div class="am-dbbox_content am-invoicelist">
        <div class="am-dbbox_title">
            @slot('title')
                {{ __('general.certificates') }}
            @endslot
            <h2>{{ __('general.certificates') }}</h2>
        </div>
        @if($isLoading)
            @include('skeletons.invoices')
        @elseif ($certificates && $certificates->isNotEmpty())
            <div class="am-invoicetable">
                <table class="am-table @if(setting('_general.table_responsive') == 'yes') am-table-responsive @endif">
                    <thead>
                        <tr>
                            <th>#{{ __('general.sr_no') }}</th>
                            <th>{{ __('general.title') }}</th>
                            <th>{{ __('calendar.certificate_for') }}</th>
                            <th>{{ __('general.date') }}</th>
                            <th>{{ __('general.issued_by') }}</th>
                            <th>{{ __('general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $key => $certificate)       
                            <tr>
                                <td data-label="{{ __('general.no') }}"><span>{{ $key + 1 }}</span></td>
                                <td data-label="{{ __('general.title') }}"><span>{{$certificate?->template->title ?? 'N/A' }} </span></td>
                                <td data-label="{{ __('calendar.subject') }}"><span>{{$certificate?->wildcard_data['course_title'] ?? $certificate?->wildcard_data['subject_name'] ?? 'N/A' }}</span></td>
                                <td data-label="{{ __('general.date') }}"><span>{{ $certificate?->created_at->format(setting('_general.date_format')) ?? 'N/A' }}</span></td>
                                <td data-label="{{ __('general.issued_by' )}}">
                                    <span>{{$certificate?->wildcard_data['tutor_name'] ?? 'N/A' }}</span>
                                </td>
                                <td data-label="{{ __('general.actions' )}}">
                                    <div class="am-invoicetable_actions">
                                        <a href="{{ route('upcertify.certificate', $certificate?->hash_id) }}" target="_blank" class="am-custom-tooltip">
                                            <span class="am-tooltip-text"><span>{{ __('general.view') }}</span></span><i class="am-icon-eye-open-01"></i>
                                        </a>
                                        <a href="{{ route('upcertify.download', $certificate?->hash_id) }}" class="am-custom-tooltip">
                                            <i class="am-icon-download-01"></i>
                                            <span class="am-tooltip-text"><span>{{ __('general.download') }}</span></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif ($certificates->isEmpty())
            <x-no-record :image="asset('images/payouts.png')" :title="__('general.no_record_title')" :description="__('general.no_records_available')"  />
        @endif
    </div>
</div>
