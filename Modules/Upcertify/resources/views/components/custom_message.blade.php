@props(['element'])
<div 
    class="{{ !empty($element['classes']) ? implode(' ', $element['classes']) : '' }}" 
    data-wildcard_name="{{ $element['wildcardName'] }}" 
    data-actions="{{ !empty($element['actions']) ? $element['actions'] : ''   }}" 
    style="{{ $element['inlineStyle'] }}"
    data-handles="{{ !empty($element['handles']) ? $element['handles'] : 'e, w' }}"
    >
    <span class="uc-wildcard_content">{!! nl2br(e($element['custom_message'])) !!}</span>
</div>