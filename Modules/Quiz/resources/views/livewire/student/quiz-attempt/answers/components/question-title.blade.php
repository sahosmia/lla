<div class="am-quizsteps_title">
    @if(!empty($question->display_points))
        <span class="am-quizsteps_title_tag">{{ $question->points }} {{ $question->points > 1 ? __('quiz::quiz.points') : __('quiz::quiz.point') }}</span>
    @endif
    @if ($question-> type == Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS)
       <div class="am-quizsteps_heading">
           <em>*</em>
           <h2>
               @if(!empty($question->settings['answer_required']))
               @endif
               {{ $questionNumber }}. {!! getStudentFillInBlanksText($question->title) !!}
           </h2>
       </div>
    @else
        <div class="am-quizsteps_heading">
            <em>*</em>
            <h2>
                {{ $questionNumber }}. {{ $question->title }}
            </h2>
        </div>
    @endif
</div>