<section class="am-upcoming-events">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                    <div class="am-section_title am-section_title_center {{ pagesetting('section_title_variation') }}">
                        @if(!empty(pagesetting('pre_heading')))
                            <span>{{ pagesetting('pre_heading') }}</span>
                        @endif
                        @if(!empty(pagesetting('heading'))) <h2>{!! pagesetting('heading') !!}</h2> @endif
                        @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                    </div>
                @endif

                @php
                    $eventsLimit = !empty(pagesetting('events_limit')) ? pagesetting('events_limit') : 4;
                @endphp
                <livewire:components.upcoming-events :eventsLimit="$eventsLimit" />
            </div>
        </div>
    </div>
</section>
