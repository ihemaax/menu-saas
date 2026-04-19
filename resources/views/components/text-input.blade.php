@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'zz-input']) }}>
