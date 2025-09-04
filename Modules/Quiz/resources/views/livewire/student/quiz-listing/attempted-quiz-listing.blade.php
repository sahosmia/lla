<div class="am-quizlist" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('quiz::quiz.attempted_quizzes_heading') }}</h2>
            <p>{{ __('quiz::quiz.attempted_quizzes_para') }}</p>
        </div>
    </div>
    <div class="am-quizlist_table">
        <table class="am-table ">
            <thead>
                <tr>
                    {{-- <th>{{ __('quiz::quiz.quiz_info') }}</th> --}}
                    <th>{{ __('quiz::quiz.student') }}</th>
                    <th>{{ __('quiz::quiz.date_time') }}</th>
                    <th>{{ __('quiz::quiz.question') }}</th>
                    <th>{{ __('quiz::quiz.total_marks') }}</th>
                    <th>{{ __('quiz::quiz.correct_answer') }}</th>
                    <th>{{ __('quiz::quiz.incorrect_answer') }}</th>
                    <th>{{ __('quiz::quiz.earned_marks') }}</th>
                    <th>{{ __('quiz::quiz.result') }}</th>
                    <th>{{ __('quiz::quiz.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($quizzes->isNotEmpty())
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td data-label="Student">
                                <div class="am-quizlist_info am-quizlist_info_student">
                                    <figure class="am-quizlist_info_img">
                                        @if (!empty($quiz->student?->profile?->image) && Storage::disk(getStorageDisk())->exists($quiz->student?->profile?->image))
                                            <img src="{{ resizedImage($quiz->student?->profile?->image,30,30) }}" alt="{{$quiz->student?->profile?->full_name}}" />
                                        @else
                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',30,30) }}" alt="{{ $image }}" />
                                        @endif
                                    </figure>
                                    <div class="am-quizlist_info_details">
                                        <strong>{{ $quiz->student?->profile?->full_name }}</strong>
                                        <span>{{ $quiz->student?->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Date & Time">
                    
                                <strong>
                                    {{ $quiz?->started_at?->format('j M Y') }}
                                    <time datetime=""> {{ $quiz?->started_at?->format('g:i A') }}</time>
                                </strong>
                            </td>
                            <td data-label="Question">{{ $quiz->total_quesetions }}</td>
                            <td data-label="Total Marks">{{ $quiz->total_marks }}</td>
                            <td data-label="Correct Answer">{{ $quiz->correct_answers }}</td>
                            <td data-label="Incorrect Answer">{{ $quiz->incorrect_answers }}</td>
                            <td data-label="Earned Marks">
                                {{ $quiz->earned_marks }} 
                                ({{ round(($quiz->earned_marks / $quiz->total_marks) * 100, 2) }}%)
                            </td>
                            <td data-label="Result">
                                <span class="am-status">
                                    <em class="am-status_declined"></em>
                                    {{__('quiz::quiz.'.$quiz->result)}}
                                </span>
                            </td>
                            <td data-label="Actions">
                                <button class="am-btn am-btn-light">
                                    {{ __('quiz::quiz.view_details') }}
                                </button>
                            </td>
                        </tr>    
                    @endforeach
                @else
                    <div class="am-emptyview">
                        <figure class="am-emptyview_img">
                            <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                        </figure>
                        <div class="am-emptyview_title">
                            <h3>No record added yet!</h3>
                            <p>Create engaging and effective quizes that inspire learning Please hit the button below to add a new one.</p>
                            <a href="{{ route('quiz.tutor.create-quiz') }}">
                            <button class="am-btn">
                                {{ __('quiz::quiz.create_quiz') }}
                                <i class="am-icon-plus-02"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                @endif 
            </tbody>
        </table>
        @if (!$quizzes->isEmpty())
        {{ $quizzes->links('quiz::pagination.pagination') }}
        @endif
       
    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" data-navigate-once>
        var component = '';
        var slider = '';
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        },{ once: true });

        document.addEventListener('loadPageJs', (event) => {
            setTimeout(function() {
                initPriceRange();
            }, 50);
        });

        document.addEventListener('resetFilters', (event) => {
            resetFilters();
        });

        function resetFilters() {
            slider.noUiSlider.reset();
            $('#category-select').val('').trigger('change.select2');
            $('#sort-select').val('desc').trigger('change.select2');
            $('#status-select').val('').trigger('change.select2');
        }

        function initPriceRange() {
            slider = document.getElementById('sliderrange');
            if (slider) {
                noUiSlider.create(slider, {
                    start: [0, 1000],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 1000
                    }
                });

                var minPriceInput = document.getElementById('cr_min_price');
                var maxPriceInput = document.getElementById('cr_max_price');

                slider.noUiSlider.on('update', function (values, handle) {
                    var value = values[handle];
                    if (handle) {
                        maxPriceInput.value = Math.round(value);
                    } else {
                        minPriceInput.value = Math.round(value);
                    }
                });

                slider.noUiSlider.on('change', function (values, handle) {
                    var minValue = Math.round(values[0]);
                    var maxValue = Math.round(values[1]);
                    component.set('filters.min_price', minValue);
                    component.set('filters.max_price', maxValue);
                });

                minPriceInput.addEventListener('change', function () {
                    slider.noUiSlider.set([this.value, null]);
                });

                maxPriceInput.addEventListener('change', function () {
                    slider.noUiSlider.set([null, this.value]);
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function( ) {
            jQuery(document).ready(function() {
                jQuery('.cr-price-dropdown').on('click', function(event) {
                    event.stopPropagation();
                    jQuery('.cr-price-range').toggle();
                });

                jQuery('.cr-price-range *').on('click', function(event) {
                    event.stopPropagation();
                });
            

                jQuery(document).on('click', function(event) {
                    if (!jQuery(event.target).closest('.cr-price-range').length && !jQuery(event.target).hasClass('cr-price-dropdown')) {
                        jQuery('.cr-price-range').hide();
                    }
                });
                
                $(document).on('change', '#cr_min_price, #cr_max_price', function(event){

                    let minValue = $('#cr_min_price').val();
                    let maxValue = $('#cr_max_price').val();
                    @this.set('filters.min_price', minValue);
                    @this.set('filters.max_price', maxValue);
                });
            });
        });

    </script>
 @endpush
