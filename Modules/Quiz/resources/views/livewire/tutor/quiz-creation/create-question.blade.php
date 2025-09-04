<div class="am-createquiz">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div x-cloak class="am-createques">
        @include('quiz::livewire.tutor.quiz-creation.components.questions.' . str_replace('_', '-', $questionType))
    </div>        
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    @vite([
        'public/summernote/summernote-lite.min.css',
    ])
@endpush

@push('scripts')
    <script src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script defer src="{{ asset('js/livewire-sortable.js')}}"></script>
@endpush