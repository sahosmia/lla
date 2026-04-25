@extends('layouts.admin-app')

@section('content')
<main class="tb-main am-dispute-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('Inquiries') .' ('. $inquiries->total() .')'}}</h4>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if( !$inquiries->isEmpty() )
                    <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('#' )}}</th>
                                <th>{{ __('Full Name' )}}</th>
                                <th>{{ __('Organization/Designation' )}}</th>
                                <th>{{ __('Contact Info' )}}</th>
                                <th>{{ __('Inquiry Type' )}}</th>
                                <th>{{ __('Message' )}}</th>
                                <th>{{ __('Created Date' )}}</th>
                                <th>{{ __('Actions' )}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiries as $inquiry)
                            <tr>
                                <td data-label="{{ __('#' )}}"><span>{{ $inquiry->id }}</span></td>
                                <td data-label="{{ __('Full Name' )}}">
                                    <span>{{ $inquiry->name }}</span>
                                </td>
                                <td data-label="{{ __('Organization/Designation' )}}">
                                    <span>
                                        {{ $inquiry->organization }}
                                        @if($inquiry->designation)
                                            / {{ $inquiry->designation }}
                                        @endif
                                    </span>
                                </td>
                                <td data-label="{{ __('Contact Info' )}}">
                                    <span>{{ $inquiry->email }}</span><br>
                                    <span>{{ $inquiry->phone }}</span>
                                </td>
                                <td data-label="{{ __('Inquiry Type' )}}">
                                    <span>{{ $inquiry->inquiry_type }}</span>
                                </td>
                                <td data-label="{{ __('Message' )}}">
                                    <span class="am-text-truncate">{{ Str::limit($inquiry->message, 50) }}</span>
                                </td>
                                <td data-label="{{ __('Created Date' )}}">
                                    <span>{{ $inquiry->created_at->format('F d, Y') }}</span>
                                </td>
                                <td data-label="{{ __('Actions' )}}">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span>{{ __('View Details') }}</span>
                                        </span>
                                        <a href="{{ route('admin.inquiries.show', $inquiry->id) }}">
                                            <i class="icon-eye"></i>
                                        </a>
                                    </div>
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span>{{ __('Delete Inquiry') }}</span>
                                        </span>
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $inquiries->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
