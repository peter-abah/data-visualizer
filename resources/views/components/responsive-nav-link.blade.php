@props(['active'])

@php
    $classes = 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-text-light hover:text-text hover:bg-bg-hover hover:border-border focus:outline-none focus:text-text  focus:bg-bg-hover focus:border-border  transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
