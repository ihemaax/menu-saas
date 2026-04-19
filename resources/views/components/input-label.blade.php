@props(['value'])

<label {{ $attributes->merge(['class' => 'zz-label']) }}>
    {{ $value ?? $slot }}
</label>
