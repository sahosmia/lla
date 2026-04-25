@props(['element', 'isPreview' => false])

<div 
    @class(
        $element['classes'] ?? [],
    )
    data-wildcard_name="{{ $element['wildcardName'] }}"
    @if(!empty($element['actions']))
        data-actions="{{ $element['actions'] }}"
    @endif
    style="{{ $element['inlineStyle'] ?? '' }}"
    data-handles="{{ $element['handles'] ?? 'e, w' }}"
>
    @if($element['wildcardName'] === 'attachment')
        <div class="uc-wildcard_content">
            @if (Str::contains($element['attachment'], '<svg')) 
                {!! $element['attachment'] !!}
            @else
                <img src="{{ asset($element['attachment']) }}" alt="Attachment image">
            @endif
        </div>
    @elseif($element['wildcardName'] === 'separation_horizontal')
    <div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_horizontal" data-actions="delete, copy" data-handles="e, w"> 
        <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_horizontal"> </span></div>
    </div>
    @elseif($element['wildcardName'] === 'separation_vertical')
        <div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_vertical" data-actions="delete, copy" data-handles="n, s"> 
            <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_vertical"> </span></div>
        </div>
    @else
        <span class="uc-wildcard_content">
            @if($isPreview)
                {{ $element['wildcardName'] }}
            @else
            {{ '[' . $element['wildcardName'] . ']' }}
            @endif
        </span>
    @endif
</div>