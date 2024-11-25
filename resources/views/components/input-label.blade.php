@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-gray-700 font-maaxRegular']) }}>
    {{ $value ?? $slot }}
</label>
