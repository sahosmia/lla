<div class="am-db-box">
    <div class="am-db-box_title">
        <h2>My Training</h2>
        <div class="am-db-box_title_btns">
            <a href="{{ route('tutor.events.create') }}" class="am-btn am-btn-small">Add Training</a>
        </div>
    </div>
    <div class="am-db-table">
        <div class="am-db-table_wrap">
            <table class="am-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date & Time</th>
                        <th>Mode</th>
                        <th>Attendees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->date_time }}</td>
                            <td>{{ $event->mode }}</td>
                            <td><a href="{{ route('tutor.events.attendees', $event->id) }}" class="am-btn am-btn-small">View ({{ $event->users_count }})</a></td>
                            <td>
                                <div class="am-table_btns">
                                    <a href="{{ route('tutor.events.edit', $event->id) }}" class="am-item_btn" title="Edit"><i class="am-icon-pencil"></i></a>
                                    <a href="{{ route('events.detail', $event->id) }}" class="am-item_btn" title="View"><i class="am-icon-eye"></i></a>
                                    <button wire:click="delete({{ $event->id }})" wire:confirm="Are you sure you want to delete this event?" class="am-item_btn am-item_btn_del" title="Delete"><i class="am-icon-trash-02"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No events found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $events->links() }}
    </div>
</div>
