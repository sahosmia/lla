@props(['field_name'])
@if(!empty($field_name))
    @error($field_name)
        <span {{ $attributes->merge(['class' => 'am-error-msg']) }}>{{ $message }}</span>
    @enderror
@endif
