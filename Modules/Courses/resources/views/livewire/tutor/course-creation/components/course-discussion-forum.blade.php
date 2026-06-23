<div class="cr-course-box">
    <div class="cr-titlewrap">
        <div class="cr-content-box cr-discussion-forum">
            <h2 class="cr-free_course">
                <span>
                    {{ __('courses::courses.discussion_forum') }}
                    <em class="cr-optional">{{ __('courses::courses.optional') }}</em>
                </span>
                <input type="checkbox" id="cr-free-course-toggle" class="cr-toggle" wire:model.live='enableDiscussionForum'>
            </h2>
            <p>{{ __('courses::courses.discussion_forum_desc_one') }}</p>
            <p>{{ __('courses::courses.discussion_forum_desc_two') }}</p>
        </div>
    </div>
    <div class="am-themeform_footer">
        <a href="{{ route('courses.tutor.edit-course', ['tab' => 'noticeboard', 'id' => $courseId]) }}" class="am-white-btn">
            <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            {{ __('courses::courses.back') }}
        </a>
        <button type="button" wire:click.prevent='save' class="am-btn" wire:loading.attr="disabled" wire:target="save" wire:loading.class="am-btn_disable">{{ __('courses::courses.save_continue') }}</button>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
@endpush

