@props(['name'])
@php
$icons = [
    'grid' => 'M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z',
    'tank' => 'M12 3c-3 3.2-6 6.6-6 10a6 6 0 0012 0c0-3.4-3-6.8-6-10z',
    'fuel' => 'M6 3h7v18H6V3zm0 7h7M16 7l3 3v7a2 2 0 01-2 2',
    'truck' => 'M3 7h11v8H3V7zm11 3h4l3 3v2h-7v-5zM7 18a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z',
    'chart' => 'M4 19V9m6 10V4m6 15v-7m6 7V11',
    'building' => 'M4 21V7l8-4 8 4v14M9 21v-6h6v6M4 21h16',
    'pin' => 'M12 21s7-6.2 7-11.5A7 7 0 005 9.5C5 14.8 12 21 12 21zM12 11a1.8 1.8 0 100-3.6A1.8 1.8 0 0012 11z',
    'droplet' => 'M12 2C9.5 5.5 7 9.2 7 13a5 5 0 0010 0c0-3.8-2.5-7.5-5-11z',
    'users' => 'M16 14a4 4 0 10-8 0M5 21a7 7 0 0114 0M12 7a3 3 0 100-6 3 3 0 000 6z',
    'logout' => 'M9 5H6a2 2 0 00-2 2v10a2 2 0 002 2h3m4-14l5 7-5 7m5-7H9',
    'plus' => 'M12 5v14m-7-7h14',
    'search' => 'M11 19a8 8 0 100-16 8 8 0 000 16zm10 2l-4.35-4.35',
    'edit' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.1 2.1 0 113 3L12 16l-4 1 1-4 9.5-9.5z',
    'trash' => 'M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0l-1 14a2 2 0 01-2 2H7a2 2 0 01-2-2L4 6h16z',
    'alert' => 'M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z',
    'check' => 'M20 6L9 17l-5-5',
    'arrow-right' => 'M5 12h14m-6-7l7 7-7 7',
    'eye' => 'M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7zm11 3a3 3 0 100-6 3 3 0 000 6z',
];
$path = $icons[$name] ?? $icons['grid'];
@endphp
<svg {{ $attributes->merge(['class' => 'h-[18px] w-[18px] shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="{{ $path }}"/>
</svg>
