<button {{ $attributes->merge(['type' => 'submit', 'class' => 'am-btn']) }}>
    {{ $slot }}
</button>
