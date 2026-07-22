<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') · SIMONITORING BBM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: { 950: '#080B11', 900: '#0D1219', 800: '#141B26', 700: '#1E2733' },
                        amber: { 50: '#FFF7ED', 100: '#FFEDD5', 400: '#FB923C', 500: '#F2790F', 600: '#D45F02' },
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    boxShadow: {
                        soft: '0 1px 2px 0 rgb(13 18 25 / 0.04), 0 8px 24px -8px rgb(13 18 25 / 0.10)',
                        glow: '0 0 0 1px rgb(242 121 15 / 0.1), 0 8px 24px -4px rgb(242 121 15 / 0.25)',
                        card: '0 2px 8px -2px rgb(13 18 25 / 0.06), 0 12px 32px -8px rgb(13 18 25 / 0.10)',
                    },
                },
            },
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F6F4EF;
            background-image:
                radial-gradient(circle at 0% 0%, rgba(242,121,15,0.05) 0%, transparent 45%),
                radial-gradient(circle at 100% 0%, rgba(13,18,25,0.04) 0%, transparent 40%);
        }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background-color: #D9D2C4; border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background-color: #C7BEAC; }
        [x-cloak] { display: none !important; }

        .sidebar-grain {
            background-image: radial-gradient(circle at 50% 0%, rgba(242,121,15,0.10) 0%, transparent 55%);
        }
        .nav-link {
            display:flex; align-items:center; gap:0.7rem; padding:0.62rem 0.85rem;
            border-radius:0.7rem; font-size:0.875rem; color:#9CA8B8; transition: all .18s cubic-bezier(.4,0,.2,1);
            margin-bottom: 2px; position: relative; font-weight: 500;
        }
        .nav-link:hover { background-color: rgba(255,255,255,0.05); color:#fff; transform: translateX(2px); }
        .nav-active {
            background: linear-gradient(135deg, rgba(242,121,15,0.18), rgba(242,121,15,0.06));
            color:#FB923C; font-weight:600;
            box-shadow: inset 2px 0 0 0 #F2790F;
        }
        .kpi-card { position:relative; overflow:hidden; }
        .kpi-card::before {
            content:''; position:absolute; top:-30%; right:-20%; width:120px; height:120px;
            border-radius:50%; background: radial-gradient(circle, currentColor 0%, transparent 70%);
            opacity:0.06; pointer-events:none;
        }
        .glass-header { background: rgba(255,255,255,0.72); backdrop-filter: blur(12px) saturate(160%); }
        .shimmer { animation: shimmer 2.2s infinite; }
        @keyframes shimmer { 0%,100%{opacity:1} 50%{opacity:.55} }
        .fade-in { animation: fadeIn .5s ease both; }
        @keyframes fadeIn { from{opacity:0; transform:translateY(6px)} to{opacity:1; transform:translateY(0)} }
    </style>
    @stack('styles')
</head>
<body class="h-full text-ink-900 antialiased">
<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- ===== SIDEBAR ===== --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed z-40 inset-y-0 left-0 w-72 bg-ink-950 text-slate-300 transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:flex flex-col sidebar-grain shadow-2xl">

        <div class="flex items-center gap-3 px-6 h-20 border-b border-white/[0.06]">
            <div class="relative h-10 w-10 shrink-0 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 grid place-items-center shadow-glow">
                <svg viewBox="0 0 24 24" class="h-5 w-5 text-ink-950" fill="currentColor"><path d="M12 2C9.5 5.5 7 9.2 7 13a5 5 0 0010 0c0-3.8-2.5-7.5-5-11z"/></svg>
            </div>
            <div>
                <p class="font-display font-bold text-white text-[15px] leading-tight tracking-tight">SIMONITORING</p>
                <p class="text-[10px] tracking-[0.22em] text-amber-400/90 font-mono font-medium">BBM&nbsp;CONTROL</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6">
            <div>
                <p class="px-3 text-[10px] font-semibold tracking-[0.18em] text-slate-500 uppercase mb-2">Ringkasan</p>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                    <x-icon name="grid" /> Dashboard
                </a>
            </div>

            <div>
                <p class="px-3 text-[10px] font-semibold tracking-[0.18em] text-slate-500 uppercase mb-2">Operasional</p>
                @if(in_array(auth()->user()->role, ['admin','operator_depot']))
                <a href="{{ route('stok-depot.index') }}" class="nav-link {{ request()->routeIs('stok-depot.*') ? 'nav-active' : '' }}">
                    <x-icon name="tank" /> Stok Terminal (Depot)
                </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin','operator_spbu']))
                <a href="{{ route('stok-spbu.index') }}" class="nav-link {{ request()->routeIs('stok-spbu.*') ? 'nav-active' : '' }}">
                    <x-icon name="fuel" /> Stok SPBU
                </a>
                @endif
                <a href="{{ route('distribusi.index') }}" class="nav-link {{ request()->routeIs('distribusi.*') ? 'nav-active' : '' }}">
                    <x-icon name="truck" /> Distribusi BBM
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'nav-active' : '' }}">
                    <x-icon name="chart" /> Laporan
                </a>
            </div>

            @if(auth()->user()->isAdmin())
            <div>
                <p class="px-3 text-[10px] font-semibold tracking-[0.18em] text-slate-500 uppercase mb-2">Data Master</p>
                <a href="{{ route('depots.index') }}" class="nav-link {{ request()->routeIs('depots.*') ? 'nav-active' : '' }}">
                    <x-icon name="building" /> Terminal BBM
                </a>
                <a href="{{ route('spbus.index') }}" class="nav-link {{ request()->routeIs('spbus.*') ? 'nav-active' : '' }}">
                    <x-icon name="pin" /> SPBU
                </a>
                <a href="{{ route('jenis-bbm.index') }}" class="nav-link {{ request()->routeIs('jenis-bbm.*') ? 'nav-active' : '' }}">
                    <x-icon name="droplet" /> Jenis BBM
                </a>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'nav-active' : '' }}">
                    <x-icon name="users" /> Pengguna
                </a>
            </div>
            @endif
        </nav>

        <div class="px-4 py-4 border-t border-white/[0.06]">
            <div class="flex items-center gap-3 px-2.5 py-2.5 rounded-xl bg-white/[0.04] ring-1 ring-white/5">
                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 grid place-items-center font-display font-bold text-ink-950 text-sm shrink-0 shadow-glow">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->roleLabel() }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg py-2 transition">
                    <x-icon name="logout" /> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div @click="sidebarOpen=false" x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden"></div>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-20 flex items-center justify-between px-5 lg:px-8 border-b border-black/[0.04] glass-header sticky top-0 z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen=true" class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-black/5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="font-display font-bold text-xl text-ink-900 tracking-tight">@yield('heading', 'Dashboard')</h1>
                    <p class="text-sm text-slate-500">@yield('subheading', 'Pantau distribusi dan ketersediaan stok BBM secara real-time.')</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-xs font-mono text-slate-600 bg-white ring-1 ring-black/[0.06] shadow-sm px-3.5 py-2 rounded-full">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                {{ now()->translatedFormat('l, d F Y · H:i') }}
            </div>
        </header>

        <main class="flex-1 p-5 lg:p-8 fade-in">
            @include('partials.alert')
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
