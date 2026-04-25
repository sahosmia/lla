<div class="am-quizsteps_box am-quizsteps_three">
    <div class="am-quizsteps_option">

        @include('quiz::livewire.student.quiz-attempt.answers.components.question-title')

        @if(!empty($question->options))
            <div class="am-quizsteps_details_wrap">
                <ul class="am-quizsteps_details">
                    @foreach ($question->options as $option)                            
                        <li>
                            <div class="am-radio">
                                <input wire:model.live="answer" id="{{ $option->id }}" type="radio" value="{{ $option->id }}" name="true_false">
                                <label for="{{ $option->id }}">
                                    {{-- <strong>{{ $loop->index == 0? 'A': 'B' }}</strong> --}}
                                    <span>{{ $option->option_text }}</span>
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    @include('quiz::livewire.student.quiz-attempt.answers.components.question-image')
    
</div>