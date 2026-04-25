<main class="tb-main am-dispute-system am-blogs-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4>Upcoming Training and Events</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedEvents ? '' : 'd-none' }}" @click="$wire.dispatch('showConfirm', { action : 'delete-event' })">{{ __('general.delete_selected') }}</a>
                                </div>
                                <a href="{{route('admin.events.create')}}" class="tb-btn tb-menubtn">
                                    Add Event <i class="icon-plus"></i>
                                </a>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="{{ __('taxonomy.search_here') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!empty($events) && $events->count() > 0)
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('general.title') }}</label>
                                        </div>
                                    </th>
                                    <th>Date & Time</th>
                                    <th>Mode</th>
                                    <th>Trainer</th>
                                    <th>Attendees</th>
                                    <th>{{__('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $single)
                                    <tr>
                                        <td data-label="{{ __('general.title') }}">
                                            <div class="tb-checkboxwithimg">
                                                <div class="tb-checkbox">
                                                    <input id="event_id{{ $single->id }}" wire:model.lazy="selectedEvents" value="{{ $single->id }}" type="checkbox">
                                                    <label for="event_id{{ $single->id }}">
                                                        @if($single->banner_image)
                                                            <img src="{{ url(Storage::url($single->banner_image)) }}" alt="{{ $single->title }}" width="100">
                                                        @endif
                                                        <span>
                                                            {!! $single->title !!}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Date & Time">{{ $single->date_time }}</td>
                                        <td data-label="Mode">{{ $single->mode }}</td>
                                        <td data-label="Trainer">{{ $single->trainer?->profile?->full_name ?? 'N/A' }}</td>
                                        <td data-label="Attendees">
                                            <a href="{{ route('admin.events.attendees', $single->id) }}" class="tb-btn tb-btn-small">View ({{ $single->users_count ?? $single->users()->count() }})</a>
                                        </td>
                                        <td data-label="{{__('general.actions')}}">
                                            <ul class="tb-action-icon">
                                                <li> <a href="{{ route('admin.events.edit', $single->id) }}"><i class="icon-edit-3"></i></a> </li>
                                                <li>
                                                    <a href="javascript:void(0);"
                                                    @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-event' })"
                                                    class="tb-delete">
                                                    <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $events->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
