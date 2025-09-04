<div class="am-quizsteps_box">
    <div class="am-quizsteps_option">

        @include('quiz::livewire.student.quiz-attempt.answers.components.question-title')

        @if (!empty($question->options))
            <div class="am-quizsteps_details_wrap">
                <ul class="am-quizsteps_details">
                    @php
                        $letter = 'A';
                        if(!empty($question->settings['random_choice'])){
                            $options = $question?->options?->shuffle();
                        }else{
                            $options = $question->options;
                        }
                    @endphp
                    @foreach ($options as $option )
                        <li>
                            <div class="am-radio">
                                <input wire:model.live="answer" value="{{ $option->id }}" id="{{ $option->id }}" type="radio" name="learning">
                                <label for="{{ $option->id }}">
                                    <span>{{ $option->option_text }}</span>
                                </label>
                            </div>
                        </li>
                    @php
                        $letter = chr(ord($letter) + 1);
                    @endphp
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @include('quiz::livewire.student.quiz-attempt.answers.components.question-image')

</div>