<div class="am-db-box">
    <div class="am-db-box_title">
        <h2>My Registered Events</h2>
    </div>
    <div class="am-db-table">
        <div class="am-db-table_wrap">
            <table class="am-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date & Time</th>
                        <th>Mode</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->date_time }}</td>
                            <td>{{ $event->mode }}</td>
                            <td><span class="am-status-tag am-status-active">Registered</span></td>
                            <td>
                                <div class="am-table_btns">
                                    <a href="{{ route('events.detail', $event->id) }}" class="am-item_btn"><i class="am-icon-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">You haven't registered for any events yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $events->links() }}
    </div>
</div>
