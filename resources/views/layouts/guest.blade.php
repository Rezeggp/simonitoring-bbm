<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk')  · SIMONITORING BBM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { ink: { 950: '#080B11', 900: '#0D1219' }, amber: { 400: '#FB923C', 500: '#F2790F', 600: '#D45F02' } },
                fontFamily: { display: ['Space Grotesk', 'sans-serif'], sans: ['Inter', 'sans-serif'], mono: ['JetBrains Mono', 'monospace'] },
                boxShadow: { glow: '0 0 0 1px rgb(242 121 15 / 0.15), 0 8px 30px -4px rgb(242 121 15 / 0.35)' },
            }},
        };
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .grid-pattern {
            background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        .noise-glow { background: radial-gradient(circle at 30% 20%, rgba(242,121,15,0.18) 0%, transparent 45%), radial-gradient(circle at 90% 80%, rgba(59,130,246,0.10) 0%, transparent 40%); }
        .float-anim { animation: floaty 6s ease-in-out infinite; }
        @keyframes floaty { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .fade-up { animation: fadeUp .6s cubic-bezier(.2,.8,.2,1) both; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        .input-focus { transition: all .2s; }
    </style>
</head>
<body class="h-full bg-[#F6F4EF]">
<div class="min-h-screen grid lg:grid-cols-2">

    {{-- Visual side --}}
    <div class="hidden lg:flex flex-col justify-between bg-ink-950 text-white p-12 relative overflow-hidden grid-pattern noise-glow">
        <div class="absolute -top-32 -right-32 h-[28rem] w-[28rem] rounded-full bg-amber-500/10 blur-3xl float-anim"></div>
        <div class="absolute bottom-0 left-0 h-72 w-72 rounded-full bg-blue-500/5 blur-3xl"></div>

        <div class="relative flex items-center gap-3 fade-up">
            <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 grid place-items-center shadow-glow">
                <svg viewBox="0 0 24 24" class="h-5 w-5 text-ink-950" fill="currentColor"><path d="M12 2C9.5 5.5 7 9.2 7 13a5 5 0 0010 0c0-3.8-2.5-7.5-5-11z"/></svg>
            </div>
            <span class="font-display font-bold text-lg tracking-tight">SIMONITORING BBM</span>
        </div>

        <div class="relative max-w-md fade-up" style="animation-delay:.1s">
            <p class="font-mono text-amber-400 text-xs tracking-[0.22em] mb-4 flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                TERMINAL → DISTRIBUSI → SPBU
            </p>
            <h1 class="font-display text-4xl leading-[1.15] font-bold mb-4 tracking-tight">Satu layar untuk memantau seluruh rantai distribusi BBM.</h1>
            <p class="text-slate-400 text-sm leading-relaxed">Pantau ketersediaan stok di terminal BBM dan SPBU, lacak status pengiriman secara langsung, dan terima peringatan dini saat stok mendekati batas minimum.</p>
        </div>

        <div class="relative grid grid-cols-3 gap-4 text-sm fade-up" style="animation-delay:.2s">
            <div class="rounded-2xl bg-white/[0.04] ring-1 ring-white/10 p-4 backdrop-blur-sm hover:bg-white/[0.07] transition">
                <p class="font-display text-2xl font-bold text-amber-400">24/7</p>
                <p class="text-slate-400 text-xs mt-1">Pemantauan real-time</p>
            </div>
            <div class="rounded-2xl bg-white/[0.04] ring-1 ring-white/10 p-4 backdrop-blur-sm hover:bg-white/[0.07] transition">
                <p class="font-display text-2xl font-bold text-amber-400">6</p>
                <p class="text-slate-400 text-xs mt-1">Jenis BBM terpantau</p>
            </div>
            <div class="rounded-2xl bg-white/[0.04] ring-1 ring-white/10 p-4 backdrop-blur-sm hover:bg-white/[0.07] transition">
                <p class="font-display text-2xl font-bold text-amber-400">Auto</p>
                <p class="text-slate-400 text-xs mt-1">Peringatan stok menipis</p>
            </div>
        </div>
    </div>

    {{-- Form side --}}
    <div class="flex items-center justify-center p-6 sm:p-12 relative">
        <div class="absolute top-0 right-0 h-64 w-64 bg-amber-100/40 rounded-full blur-3xl -z-10"></div>
        <div class="w-full max-w-sm fade-up" style="animation-delay:.15s">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
