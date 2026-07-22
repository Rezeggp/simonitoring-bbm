@props(['percentage' => 0, 'size' => 64, 'critical' => false])
@php
    $pct = max(0, min(100, (float) $percentage));
    $radius = ($size / 2) - 6;
    $circumference = 2 * M_PI * $radius;
    $offset = $circumference * (1 - $pct / 100);
    $isCritical = $critical || $pct <= 20;
    $isWarn = !$isCritical && $pct <= 45;
    $color = $isCritical ? '#DC2626' : ($isWarn ? '#F2790F' : '#16A34A');
    $glow = $isCritical ? 'rgba(220,38,38,0.25)' : ($isWarn ? 'rgba(242,121,15,0.2)' : 'rgba(22,163,74,0.18)');
@endphp
<div class="relative shrink-0" style="width: {{ $size }}px; height: {{ $size }}px; filter: drop-shadow(0 2px 6px {{ $glow }});">
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" class="-rotate-90">
        <defs>
            <linearGradient id="grad-{{ $size }}-{{ (int)($pct*10) }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="{{ $color }}" stop-opacity="0.7"/>
                <stop offset="100%" stop-color="{{ $color }}" stop-opacity="1"/>
            </linearGradient>
        </defs>
        <circle cx="{{ $size/2 }}" cy="{{ $size/2 }}" r="{{ $radius }}" fill="none" stroke="#ECE8DF" stroke-width="6"/>
        <circle cx="{{ $size/2 }}" cy="{{ $size/2 }}" r="{{ $radius }}" fill="none" stroke="url(#grad-{{ $size }}-{{ (int)($pct*10) }})" stroke-width="6"
                stroke-linecap="round" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}"
                style="transition: stroke-dashoffset .8s cubic-bezier(.4,0,.2,1);"/>
    </svg>
    <div class="absolute inset-0 grid place-items-center">
        <span class="font-mono font-bold text-ink-900" style="font-size: {{ $size * 0.22 }}px;">{{ number_format($pct, 0) }}%</span>
    </div>
    @if($isCritical)
    <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white">
        <span class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 animate-ping"></span>
    </span>
    @endif
</div>
