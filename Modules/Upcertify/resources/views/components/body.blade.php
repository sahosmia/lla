@props(['body', 'isPreview' => false])
<div class="uc-certificatebox">
    <div class="uc-course_box" id="uc-canvas-boundry" 
    @if(!empty($body['backgroundColorStyle']) && $body['backgroundColorStyle'] !== 'rgb(255, 255, 255)')
        style="background-color: {{ $body['backgroundColorStyle'] }};"
    @elseif(!empty($body['backgroundImage']))
        style="background-image: url('{{ $body['backgroundImage'] }}'); {{ $body['inlineStyle'] ?? '' }}"
    @endif
    >
        @if(!empty($body['elementsInfo']))
            @foreach ($body['elementsInfo'] as $element)
                @if($element['wildcardName'] == 'custom_message')
                    <x-upcertify::custom_message :element="$element" />
                @else
                    <x-upcertify::wildcard :element="$element" :isPreview="$isPreview" />
                @endif
            @endforeach
        @endif
        @if(!$isPreview)
            <svg class="uc-border-svg "><rect width="100%" height="100%"></rect></svg>
        @endif
    </div>
</div>