@php
    use App\Livewire\Components\TrainingCalendars;
@endphp
@if(function_exists('isTrainingCalendarModuleEnabled') && isTrainingCalendarModuleEnabled() && TrainingCalendars::hasTrainings())
    <section class="am-feedback am-courses-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                        <div class="am-section_title am-section_title_center {{ pagesetting('section_title_variation') }}">
                            @if(!empty(pagesetting('pre_heading')))
                                <span
                                    @if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'))
                                        style="
                                            @if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)')
                                                color: {{ pagesetting('pre_heading_text_color') }};
                                            @endif
                                            @if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')
                                                background-color: {{ pagesetting('pre_heading_bg_color') }};
                                            @endif
                                        "
                                    @endif>
                                    {{ pagesetting('pre_heading') }}
                                </span>
                            @endif
                            @if(!empty(pagesetting('heading'))) <h2>{!! pagesetting('heading') !!}</h2> @endif
                            @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                        </div>
                    @endif
                    @php
                        $trainingsLimit = !empty(pagesetting('trainings_limit')) ? pagesetting('trainings_limit') : 6;
                    @endphp
                    <livewire:components.training-calendars :trainingsLimit="$trainingsLimit" />
                </div>
            </div>
        </div>
    </section>
@endif
