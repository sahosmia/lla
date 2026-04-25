@if(!empty($question->video) && Storage::disk(getStorageDisk())->exists($question->video?->path))
    <video class="video-js am-quizsteps_video" data-setup='{}' preload="auto" wire:key="auth-video" id="auth-video" width="300" height="300" controls >
        <source src="{{ Storage::disk(getStorageDisk())->url($question->video?->path) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
    </video>
@endif