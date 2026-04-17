@props(['name', 'class' => 'h-5 w-5'])

@switch($name)
    @case('menu')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        @break
    @case('home')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12 11.204 3.522a1.125 1.125 0 0 1 1.592 0L21.75 12M4.5 9.75V19.5a1.5 1.5 0 0 0 1.5 1.5h3.75v-5.25a1.5 1.5 0 0 1 1.5-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5V21H18a1.5 1.5 0 0 0 1.5-1.5V9.75"/></svg>
        @break
    @case('category')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A1.5 1.5 0 0 1 5.25 5.25h5.25A1.5 1.5 0 0 1 12 6.75V12a1.5 1.5 0 0 1-1.5 1.5H5.25A1.5 1.5 0 0 1 3.75 12V6.75ZM12 6.75a1.5 1.5 0 0 1 1.5-1.5h5.25a1.5 1.5 0 0 1 1.5 1.5V12a1.5 1.5 0 0 1-1.5 1.5H13.5A1.5 1.5 0 0 1 12 12V6.75ZM3.75 16.5A1.5 1.5 0 0 1 5.25 15h5.25A1.5 1.5 0 0 1 12 16.5v1.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-1.5ZM12 16.5A1.5 1.5 0 0 1 13.5 15h5.25a1.5 1.5 0 0 1 1.5 1.5v1.5a1.5 1.5 0 0 1-1.5 1.5H13.5a1.5 1.5 0 0 1-1.5-1.5v-1.5Z"/></svg>
        @break
    @case('product')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5M4.5 7.5h15m-13.5 0 1.5 12.75A1.5 1.5 0 0 0 9 21.75h6a1.5 1.5 0 0 0 1.5-1.5L18 7.5"/></svg>
        @break
    @case('settings')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.28c.06.36.3.67.64.84l1.16.58c.33.17.72.18 1.06.03l1.21-.55a1.125 1.125 0 0 1 1.41.44l1.296 2.244a1.125 1.125 0 0 1-.25 1.45l-1.01.86c-.28.24-.4.62-.33.98l.26 1.32c.07.35.29.64.6.81l1.13.62a1.125 1.125 0 0 1 .45 1.47l-1.295 2.244a1.125 1.125 0 0 1-1.41.44l-1.2-.55c-.34-.16-.73-.15-1.07.02l-1.16.59c-.34.17-.58.48-.64.84l-.213 1.28c-.09.54-.56.94-1.11.94h-2.593c-.55 0-1.02-.4-1.11-.94l-.213-1.28a1.125 1.125 0 0 0-.64-.84l-1.16-.59a1.125 1.125 0 0 0-1.07-.02l-1.2.55a1.125 1.125 0 0 1-1.41-.44L2.7 16.27a1.125 1.125 0 0 1 .45-1.47l1.13-.62c.31-.17.53-.46.6-.81l.26-1.32a1.125 1.125 0 0 0-.33-.98l-1.01-.86a1.125 1.125 0 0 1-.25-1.45L4.84 6.51a1.125 1.125 0 0 1 1.41-.44l1.21.55c.34.15.73.14 1.06-.03l1.16-.58c.34-.17.58-.48.64-.84l.213-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
        @break
    @case('palette')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3.375 3.375 0 0 1-4.758-4.758l6.75-6.75a3.375 3.375 0 1 1 4.758 4.758l-1.19 1.19m-5.56 5.56 2.475 2.475a3.375 3.375 0 0 0 4.773 0l3.182-3.182a3.375 3.375 0 0 0 0-4.773l-2.475-2.475"/></svg>
        @break
@endswitch
