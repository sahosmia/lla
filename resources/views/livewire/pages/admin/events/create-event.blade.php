<main class="tb-main">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4>Add New Event</h4>
                <div class="tb-sortby">
                    <a href="{{ route('admin.events.index') }}" class="tb-btn tb-menubtn">Back to Events</a>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <form wire:submit.prevent="save" class="tb-themeform tb-displistform">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="tb-label">Title</label>
                            <input type="text" wire:model="title" class="form-control" placeholder="Event Title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="tb-label">Display Date & Time</label>
                            <input type="text" wire:model="date_time" class="form-control" placeholder="e.g. Saturday, 17 January 2026 or To be announced">
                            @error('date_time') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="tb-label">Sorting Date (For chronological order)</label>
                            <input type="datetime-local" wire:model="sort_date" class="form-control">
                            @error('sort_date') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="tb-label">Mode</label>
                            <input type="text" wire:model="mode" class="form-control" placeholder="e.g. Online, Physical, Hybrid">
                            @error('mode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="tb-label">Trainer (Tutor)</label>
                            <select wire:model="user_id" class="form-control">
                                <option value="">Select Trainer</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->profile?->full_name }} ({{ $tutor->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="tb-label">Banner Image</label>
                            <input type="file" wire:model="banner_image" class="form-control">
                            @error('banner_image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="tb-btn">Save Event</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
