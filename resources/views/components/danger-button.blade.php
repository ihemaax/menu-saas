<button {{ $attributes->merge(['type' => 'submit', 'class' => 'zz-btn-danger']) }}>
    {{ $slot }}
</button>
