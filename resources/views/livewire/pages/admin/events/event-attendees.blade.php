@if(Auth::user()->hasRole('admin'))
    <main class="tb-main">
        <div class="row">
            <div class="col-lg-12 col-md-12 tb-md-12">
                <div class="tb-dhb-mainheading">
                    <h4>Attendees for: {{ $event->title }}</h4>
                    <div class="tb-sortby">
                        <div class="form-group tb-inputicon tb-inputheight">
                            <i class="icon-search"></i>
                            <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="Search by name or email">
                        </div>
                        <a href="{{ route('admin.events.index') }}" class="tb-btn tb-menubtn">Back to Events</a>
                    </div>
                </div>
                <div class="am-disputelist_wrap">
                    <div class="am-disputelist am-custom-scrollbar-y">
                        @if(!empty($attendees) && $attendees->count() > 0)
                            <table class="tb-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Profession</th>
                                        <th>Organization</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendees as $attendee)
                                        <tr>
                                            <td>{{ $attendee->name ?? 'N/A' }}</td>
                                            <td>{{ $attendee->email }}</td>
                                            <td>{{ $attendee->profession ?? 'N/A' }}</td>
                                            <td>{{ $attendee->organization ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendee->created_at)->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $attendees->links('pagination.custom') }}
                        @else
                            <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@else
    <div class="am-profile-setting">
        <div class="am-userperinfo">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>Attendees for: {{ $event->title }}</h2>
                    <p>List of all users registered for this event</p>
                </div>
                <div class="am-dbbox_title_sorting">
                    <div class="am-dbbox_title_sorting_input">
                        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search by name or email">
                        <i class="am-icon-search-02"></i>
                    </div>
                </div>
                <a href="{{ route('tutor.events.index') }}" class="am-btn am-btnsmall am-btn-outline">Back to Events</a>
            </div>
            <div class="am-db-table">
                <div class="am-db-table_wrap">
                    @if(!empty($attendees) && $attendees->count() > 0)
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Profession</th>
                                    <th>Organization</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendees as $attendee)
                                    <tr>
                                        <td data-label="Name">{{ $attendee->name ?? 'N/A' }}</td>
                                        <td data-label="Email">{{ $attendee->email }}</td>
                                        <td data-label="Profession">{{ $attendee->profession ?? 'N/A' }}</td>
                                        <td data-label="Organization">{{ $attendee->organization ?? 'N/A' }}</td>
                                        <td data-label="Registration Date">{{ \Carbon\Carbon::parse($attendee->created_at)->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $attendees->links() }}
                    @else
                        <div class="text-center py-5">
                            <p>No attendees found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
