@props(['class' => 'w-9 h-9'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" fill="none" {{ $attributes->merge(['class' => $class]) }}>
    <circle cx="20" cy="20" r="19" fill="#2e7d32"/>
    <path d="M20 8c-6.5 0-11 5-11 11 0 5 3.5 9 8 10.5 0-3 .5-6 3-9 2.5 3 3 6 3 9 4.5-1.5 8-5.5 8-10.5 0-6-4.5-11-11-11z"
          fill="white" fill-opacity="0.95"/>
    <path d="M20 14c1.5 2 2 4 2 6.5" stroke="#2e7d32" stroke-width="1.2" stroke-linecap="round"/>
</svg>