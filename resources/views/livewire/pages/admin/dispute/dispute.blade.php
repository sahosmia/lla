<main class="tb-main am-dispute-system" wire:init="loadData">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading ">
                <h4> {{ __('dispute.all_disputes') .' ('. $disputes->total() .')'}}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" {{ $status == '' ? 'selected' : '' }}>{{ __('dispute.all') }}</option>
                                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>{{ __('dispute.pending') }}</option>
                                            <option value="under_review" {{ $status == 'under_review' ? 'selected' : '' }}>{{ __('dispute.under_review') }}</option>
                                            <option value="in_discussion" {{ $status == 'in_discussion' ? 'selected' : '' }}>{{ __('dispute.in_discussion') }}</option>
                                            <option value="closed" {{ $status == 'closed' ? 'selected' : '' }}>{{ __('dispute.closed') }}</option>
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
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="keyword"  autocomplete="off" placeholder="{{ __('general.search') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                        <thead>
                            <tr>
                                <th>{{ __('dispute.dispute') }}</th>
                                <th>{{ __('dispute.session') }}</th>
                                <th>{{ __('dispute.student') }}</th>
                                <th>{{ __('dispute.tutor') }}</th>
                                <th>{{ __('dispute.date_created') }}</th>
                                <th>{{ __('dispute.status') }}</th>
                                <th class="am-dispute-action">Action</th>
                            </tr>
                        </thead>
                        @if(!$isLoading)
                            <tbody class="d-none" wire:loading.class.remove="d-none" wire:target="status,sortby,keyword">
                                @include('skeletons.admin-dispute', ['perPage' => $perPage])
                            </tbody>
                            <tbody wire:loading.class="d-none" wire:target="status,keyword,sortby">
                                @if( !$disputes->isEmpty() )
                                    @foreach($disputes as $dispute)
                                        <tr>
                                            <td data-label="{{ __('dispute.dispute') }}"><span>{{ $dispute?->dispute_reason }} <small>{{ $dispute?->uuid }}</small></span></td>
                                            <td data-label="{{ __('dispute.session') }}">
                                                <div class="am-list-wrap">
                                                    <figure class="am-img-rounded">
                                                        @if (!empty($dispute?->booking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->slot?->subjectGroupSubjects?->image))
                                                        <img src="{{ resizedImage($dispute?->booking?->slot?->subjectGroupSubjects?->image,34,34) }}" alt="{{$dispute?->booking?->slot?->subjectGroupSubjects?->image}}" />
                                                        @else 
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png',34,34) }}" alt="{{ $dispute?->booking?->slot?->subjectGroupSubjects?->image }}" />
                                                        @endif
                                                    </figure>
                                                    <span>{{ $dispute?->booking?->slot?->subjectGroupSubjects?->subject?->name  }}<br>
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
                                            <td data-label="{{ __('dispute.student' )}}">
                                                <div class="am-list-wrap">
                                                    <figure>
                                                        @if (!empty($dispute?->booking?->student?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->student?->image))
                                                        <img src="{{ resizedImage($dispute?->booking?->student?->image,34,34) }}" alt="{{$dispute?->booking?->student?->image}}" />
                                                        @else
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png', 34, 34) }}" alt="{{ $dispute?->booking?->student?->image}}" />
                                                        @endif
                                                    </figure>
                                                    <span>
                                                        <span>
                                                            {{ $dispute?->creatorBy?->profile?->full_name }} 
                                                            @if($dispute?->winner_id == $dispute?->creatorBy?->id)
                                                            <div class="am-custom-tooltip">
                                                                <span class="am-tooltip-text">
                                                                    <span>{{ __('general.winning_party') }}</span>
                                                                </span>
                                                                <i class="icon-check-circle"></i>
                                                            </div>
                                                            @endif
                                                        </span> 
                                                        <small>{{ $dispute?->creatorBy?->email }}</small>
                                                    </span>
                                                </div>
                                            </td>
                                            <td data-label="{{ __('dispute.tutor' )}}">
                                                <div class="am-list-wrap">
                                                    <figure>
                                                        @if (!empty($dispute?->booking?->tutor?->image) && Storage::disk(getStorageDisk())->exists($dispute?->booking?->tutor?->image))
                                                        <img src="{{ resizedImage($dispute?->booking?->tutor?->image,34,34) }}" alt="{{$dispute?->booking?->tutor?->image}}" />
                                                        @else 
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? Storage::url(setting('_general.default_avatar_for_user')[0]['path']) : resizedImage('placeholder.png',34,34) }}" alt="{{ $dispute?->booking?->tutor?->image }}" />
                                                        @endif
                                                    </figure>
                                                    <span>
                                                        <span>
                                                            {{ $dispute?->responsibleBy?->profile?->full_name }} 
                                                            @if($dispute?->winner_id == $dispute?->responsibleBy?->id)
                                                            <div class="am-custom-tooltip">
                                                                <span class="am-tooltip-text">
                                                                    <span>{{ __('general.winning_party') }}</span>
                                                                </span>
                                                                <i class="icon-check-circle"></i>
                                                            </div>
                                                            @endif
                                                        </span>
                                                        <small>{{ $dispute?->responsibleBy?->email }}</small>
                                                    </span>
                                                </div>
                                            </td>
                                            <td data-label="{{ __('dispute.date_created') }}">
                                                <em>{{ \Carbon\Carbon::parse($dispute?->created_at)->format('d M Y') }}</em>
                                            </td>
                                            <td data-label="{{ __('dispute.status' )}}">
                                                <div class="am-status-tag">
                                                    <span class="tk-project-tag am-{{str_replace('_', '-', $dispute?->status)}}">{{ ucfirst(str_replace('_', ' ', $dispute?->status)) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <a wire:click="viewDetail('{{ $dispute?->uuid }}')" class="tk-project-tag-two am-view-btn">View Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        @else
                            <tbody>
                                @include('skeletons.admin-dispute', ['perPage' => $perPage])
                            </tbody>
                         @endif
                    </table>
                    @if ($disputes->isEmpty() && !$isLoading)
                        <div class="am-disputelist-empty" wire:loading.class="d-none" wire:target="status,keyword,sortby">
                            <x-no-record :image="asset('images/empty.png')" :title="__('dispute.no_record_title')" />
                        </div>
                    @endif
                </div>
                @if (!$disputes->isEmpty() && !$isLoading)
                    {{ $disputes->links('pagination.custom') }}
                @endif
            </div>
            </div>
        </div>
    </div>
</main>
