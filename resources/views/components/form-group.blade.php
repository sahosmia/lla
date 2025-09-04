<div class="{{ $errors->get($fieldName) ? 'am-invalid' : '' }}" {!! $attributes->merge(['class' => 'form-group']) !!}>
    <div class="am-placeholderholder">
        <div class="am-placeholder">
            <span class="am-important">{{ $fieldLabel }}</span>
            @if (isset($required))
            @endif
        </div>
        <x-text-input wire:model="{{ $fieldName }}" name="{{ $fieldName }}" type="{{ $fieldType }}" placeholder="{{ $placeholder }}" class="form-control" value="{{ $fieldValue ?? old($fieldName) }}" required="{{ $required }}"></x-text-input>
        <x-input-error field_name="{{ $fieldName }}" />
    </div>
</div>
