@props(['value'])

<label {{ $attributes->merge(['class' => 'am-label']) }}>
    {{ $value ?? $slot }}
</label>
