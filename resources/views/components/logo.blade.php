@props(['class' => 'w-9 h-9'])

<img src="{{ asset('images/logo-transparent.png') }}" alt="BANTAY logo" {{ $attributes->merge(['class' => $class . ' object-contain']) }}>