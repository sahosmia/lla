<div class="am-dbbox am-dispute-system" wire:init="loadData">
    <div class="am-dbbox_content">
        <div class="am-dbbox_title">
            <h2>{{ __('dispute.disputes_overview') }}</h2>
            <div class="am-dbbox_title_sorting">
                <div class="am-inputicon">
                    <input type="text" placeholder="Search here" class="form-control" wire:model.live.debounce.500ms="keyword"  autocomplete="off" placeholder="{{ __('general.search') }}">
                    <a href="#"><i class="am-icon-search-02"></i></a>
                </div>
                <span class="am-select" wire:ignore>
                    <select data-componentid="@this" data-live="true" class="am-select2" id="status"
                        data-wiremodel="status">
                        <option value="" {{ $status == '' ? 'selected' : '' }}>{{ __('dispute.all') }}</option>
                        @if(auth()->user()->role == 'student')
                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('dispute.pending') }}</option>
                            <option value="under_review" {{ $status == 'under_review' ? 'selected' : '' }}>{{ __('dispute.under_review') }}</option>
                        @endif
                        <option value="in_discussion" {{ $status == 'in_discussion' ? 'selected' : '' }}>{{ __('dispute.in_discussion') }}</option>
                        <option value="closed" {{ $status == 'closed' ? 'selected' : '' }}>{{ __('dispute.closed') }}</option>
                    </select>
                </span>
            </div>
        </div>
        <div class="am-disputelist_wrap">
            <div class="am-disputelist am-custom-scrollbar-y">
                <table class="am-table @if(setting('_general.table_responsive') == 'yes') am-table-responsive @endif">
                    <thead>
                        <tr>
                            <th>{{ __('dispute.dispute') }}</th>
                            <th>{{ __('dispute.session') }}</th>
                            @if(auth()->user()->role == 'tutor')
                                <th>{{ __('dispute.student') }}</th>
                            @elseif(auth()->user()->role == 'student')
                                <th>{{ __('dispute.tutor') }}</th>
                            @endif
                            <th>{{ __('dispute.date_created') }}</th>
                            <th>
                                <div class="am-status-action">
                                    <span>{{ __('dispute.status') }}</span>
                                    <span>{{ __('dispute.action') }}</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    @if (!$isLoading)
                        <tbody class="d-none" wire:loading.class.remove="d-none" wire:target="status,keyword">
                            @include('skeletons.dispute', ['perPage' => $perPage])
                        </tbody>
                        <tbody wire:loading.class="d-none" wire:target="status,keyword">
                            @if(!$disputes->isEmpty())
                                @foreach($disputes as $dispute)
                                <tr>
                                    <td data-label="{{ __('dispute.dispute') }}">
                                        <span>{{ $dispute?->dispute_reason }}
                                            <small>{{ $dispute?->uuid }}</small>
                                        </span>
                                    </td>
                                    <td data-label="{{ __('dispute.session' )}}">
                                        <div class="am-list-wrap">
                                            <figure class="am-img-rounded">
                                                @if (!empty($dispute?->booking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->slot?->subjectGroupSubjects?->image))
                                                <img src="{{ resizedImage($dispute?->booking?->slot?->subjectGroupSubjects?->image,34,34) }}" alt="{{$dispute?->booking?->slot?->subjectGroupSubjects?->image}}" />
                                                @else
                                                    <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="image" />
                                                @endif
                                            </figure>
                                            <span>{{ $dispute?->booking?->slot?->subjectGroupSubjects?->subject?->name  }}
                                                <small>{{ $dispute?->booking?->slot?->subjectGroupSubjects?->group?->name }} 
                                                    @if(setting('_lernen.time_format') == '12') 
                                                        {{ \Carbon\Carbon::parse($dispute?->booking?->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($dispute?->booking?->end_time)->format('h:i A') }} 
                                                    @else 
                                                        {{ \Carbon\Carbon::parse($dispute?->booking?->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($dispute?->booking?->end_time)->format('H:i') }} 
                                                    @endif 
                                                </small>
                                            </span>
                                        </div>
                                    </td>
                                    @if(auth()->user()->role == 'student')
                                        <td data-label="{{ __('dispute.tutor') }}">
                                            <div class="am-list-wrap ">
                                                <figure>
                                                    @if (!empty($dispute?->responsibleBy?->profile?->image) && Storage::disk(getStorageDisk())->exists($dispute?->responsibleBy?->profile?->image))
                                                    <img src="{{ resizedImage($dispute?->responsibleBy?->profile?->image,34,34) }}" alt="{{$dispute?->responsibleBy?->profile?->image}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->responsibleBy?->profile?->image }}" />
                                                    @endif
                                                </figure>
                                                <span>{{$dispute?->responsibleBy?->profile?->full_name }} 
                                                    <small>{{$dispute?->responsibleBy?->email }}</small>
                                                </span>
                                            </div>
                                        </td>
                                    @elseif(auth()->user()->role == 'tutor')
                                        <td data-label="{{ __('dispute.student') }}">
                                            <div class="am-list-wrap">
                                                <figure>
                                                    @if (!empty($dispute?->creatorBy?->profile?->image) && Storage::disk(   'public')->exists($dispute?->creatorBy?->profile?->image))
                                                    <img src="{{ resizedImage($dispute?->creatorBy?->profile?->image,34,34) }}" alt="{{$dispute?->creatorBy?->profile?->image}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->creatorBy?->profile?->image }}" />
                                                    @endif
                                                </figure>
                                                <span>{{ $dispute?->creatorBy?->profile?->full_name }}
                                                    <small>{{$dispute?->creatorBy?->email }}</small>
                                                </span>
                                            </div>
                                        </td>
                                    @endif
                                    <td data-label="{{ __('Date Created') }}"><em>{{ \Carbon\Carbon::parse($dispute?->created_at)->format('F j, Y, g:i A') }}</em></td>
                                    <td data-label="{{ __('Status') }}">
                                        <div class="am-status-tag">
                                            <span class="tk-project-tag-two am-{{str_replace('_', '-', $dispute?->status)}} {{ $dispute?->status == 'pending' ? 'tk-hourly-tag' : 'tk-fixed-tag' }}">{{ ucfirst(str_replace('_', ' ', $dispute?->status)) }}</span>
                                            <a href="javascript:void(0)" wire:click="viewDetail('{{ $dispute?->uuid }}')" class="tk-project-tag-two am-view-btn">{{ __('dispute.view_detail') }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    @else
                        <tbody>
                            @include('skeletons.dispute', ['perPage' => $perPage])
                        </tbody>
                    @endif
                </table>
                @if ($disputes->isEmpty() && !$isLoading)
                    <div class="am-disputelist-empty" wire:loading.class="d-none" wire:target="status,keyword">
                        <x-no-record :image="asset('images/payouts.png')" :title="__('general.no_disputes')"
                        :description="__('general.no_disputes_desc')"  />
                    </div>
                @endif
            </div>
            @if(!$disputes->isEmpty())
                    {{ $disputes->links('pagination.pagination') }}
            @endif
        </div>
    </div>
</div>

