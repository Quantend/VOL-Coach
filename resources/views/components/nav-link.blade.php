@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-2 pt-2 border-b-2 border-pink-400 text-lg font-medium leading-5 text-pink-400 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out hover:text-pink-300'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-lg font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
