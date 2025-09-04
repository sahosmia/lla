<div class="cr-publish_success">
    <div class="cr-icon">
        <span class="cr-checkmark">
            <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" viewBox="0 0 46 46" fill="none">
                <path d="M8 24.875L17.375 34.25L38 11.75" stroke="#17B26A" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
    <div class="cr-publish_content">
        <h2>{{ __('courses::courses.course_successfully_created') }}</h2>
        <p>{{ __('courses::courses.course_live_ready') }}</p>
        <p>{{ __('courses::courses.thank_you_contributing') }}</p>
    </div>
    <a href="{{ route('courses.tutor.courses') }}" class="am-btn">{{ __('courses::courses.go_to_dashboard') }}</a>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
@endpush

