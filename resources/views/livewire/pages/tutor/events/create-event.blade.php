<div class="am-db-box">
    <div class="am-db-box_title">
        <h2>Add New Event</h2>
        <a href="{{ route('tutor.events.index') }}" class="am-btn am-btn-small am-btn-outline">Back to Events</a>
    </div>
    <div class="am-db-box_content">
        <form wire:submit.prevent="save" class="am-themeform">
            <div class="row">
                <div class="col-12 form-group">
                    <label class="am-label">Title</label>
                    <input type="text" wire:model="title" class="form-control" placeholder="Event Title">
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label class="am-label">Display Date & Time</label>
                    <input type="text" wire:model="date_time" class="form-control" placeholder="e.g. Saturday, 17 January 2026">
                    @error('date_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label class="am-label">Sorting Date</label>
                    <input type="datetime-local" wire:model="sort_date" class="form-control">
                    @error('sort_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label class="am-label">Event Mode</label>
                    <select wire:model.live="mode" class="form-control">
                        <option value="Virtual">Virtual</option>
                        <option value="Physical">Physical</option>
                    </select>
                    @error('mode') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label class="am-label">Banner Image</label>
                    <input type="file" wire:model="banner_image" class="form-control">
                    @error('banner_image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if($mode === 'Physical')
                    <div class="col-md-8 form-group">
                        <label class="am-label">Venue Address</label>
                        <input type="text" wire:model="venue_address" class="form-control" placeholder="Detailed Address">
                        @error('venue_address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="am-label">City</label>
                        <input type="text" wire:model="venue_city" class="form-control" placeholder="City">
                        @error('venue_city') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="col-12 mt-4">
                    <button type="submit" class="am-btn">Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div>
