<button {{ $attributes->merge(['type' => 'submit', 'class' => 'zz-btn-primary']) }}>
    {{ $slot }}
</button>
