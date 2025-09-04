<ul class="am-userperinfo_tab">
    <li @class([
        'am-active'     => $routeName == 'quiz.tutor.quiz-details',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ])>
        <a href="{{ $routeName == 'quiz.tutor.quiz-details' ? 'javascript:void(0);': route('quiz.tutor.quiz-details', ['quizId' => $quizId]) }}">
            {{ __('quiz::quiz.basic_details') }}
        </a>
    </li>
    <li @class([
        'am-active'     => $routeName == 'quiz.tutor.quiz-settings',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ])>
        <a href="{{ $routeName == 'quiz.tutor.quiz-settings' ? 'javascript:void(0);': route('quiz.tutor.quiz-settings', ['quizId' => $quizId]) }}">
            {{ __('quiz::quiz.quiz_setting') }}
        </a>
    </li>
    <li @class([
        'am-active'     => $routeName == 'quiz.tutor.question-manager',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ])>
        <a href="{{ $routeName == 'quiz.tutor.question-manager' ? 'javascript:void(0);': route('quiz.tutor.question-manager', ['quizId' => $quizId]) }}">
            {{ __('quiz::quiz.question_manager') }}
        </a>
    </li>
    <li class="{{ $routeName == 'quiz.tutor.quiz-attempts' ? 'am-active' : '' }}">
        <a href="{{ $routeName == 'quiz.tutor.quiz-attempts' ? 'javascript:void(0);': route('quiz.tutor.quiz-attempts', ['quizId' => $quizId]) }}">
            {{ __('quiz::quiz.students') }}
        </a>
    </li>
</ul>

