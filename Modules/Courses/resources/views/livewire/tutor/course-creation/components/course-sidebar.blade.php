<div class="cr-course-creation">
    <h2>{{ __('courses::courses.sourses_tep', ['current' => $currentTabNumber + 1, 'total' => count($tabs)]) }}</h2>
    <p>{{ __('courses::courses.step_description') }}</p>

    <ul class="cr-steps">
        @foreach($tabs as $tab => $value)
            <li 
            @class([
                'cr-active' => $tab === $activeTab,
                'cr-completed' => $currentTabNumber >= $value['step']
            ])
            @if($currentTabNumber >= $value['step']) wire:click="navigateToRoute('{{ $tab }}')" @endif
            >
                <span class="cr-icon">
                    <i class="{{ $value['icon'] }}"></i>
                    <svg class="cr-checked" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.66602 8.66667L5.99935 12L13.3327 4" stroke="#754FFE" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <div class="cr-steps_info">
                    <strong>{{ $value['title'] }}
                        @if($value['required'])
                            <svg width="6" height="8" viewBox="0 0 6 8" fill="none">
                                <path d="M5.21875 6.07422L3.34375 4.76953L3.53906 7.01953H2.28906L2.48438 4.76172L0.609375 6.07422L0 4.95703L2.0625 4.01172L0 3.05859L0.609375 1.92578L2.48438 3.26953L2.28906 0.980469H3.53906L3.34375 3.26953L5.21875 1.92578L5.82812 3.05859L3.77344 4.01172L5.82812 4.95703L5.21875 6.07422Z" fill="#D92D20" />
                            </svg>
                        @endif
                    </strong>
                    @if($tab === 'details')
                        <span class="cr-description">{{ __('courses::courses.basic_details_info') }}</span>
                    @endif
                    <em>
                        {{ __('courses::courses.edit_again') }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M8.75065 2.91675C8.75065 4.20541 9.79532 5.25008 11.084 5.25008M2.33398 11.6667L2.69563 9.8585C2.77803 9.44651 2.81923 9.24051 2.89458 9.04842C2.96145 8.87792 3.04817 8.71589 3.15294 8.56567C3.27098 8.39643 3.41952 8.24788 3.71662 7.95079L9.33406 2.3334C9.65211 2.01536 9.81114 1.85633 9.98268 1.77132C10.3091 1.60956 10.6923 1.60957 11.0188 1.77133C11.1903 1.85635 11.3493 2.01538 11.6674 2.33343V2.33343C11.9854 2.65148 12.1444 2.8105 12.2294 2.98205C12.3912 3.30846 12.3912 3.69169 12.2294 4.01811C12.1444 4.18965 11.9854 4.34867 11.6674 4.66671L6.04994 10.2841C5.75285 10.5812 5.6043 10.7298 5.43506 10.8478C5.28484 10.9526 5.12281 11.0393 4.95231 11.1062C4.76022 11.1815 4.55423 11.2227 4.14224 11.3051L2.33398 11.6667Z" stroke="#585858" stroke-width="1.3125" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </em>
                </div>
            </li>
        @endforeach
    </ul>
</div>
