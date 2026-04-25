@if(!empty($question->thumbnail) && Storage::disk(getStorageDisk())->exists($question->thumbnail?->path))
    <figure class="am-quizsteps_img">
        <img src="{{ Storage::disk(getStorageDisk())->url($question->thumbnail?->path) }}" alt="{{ $question->question_title }}">
    </figure>
@endif