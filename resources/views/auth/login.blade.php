@extends('layouts.guest')
@section('title', 'Masuk')

@section('content')
    <div class="mb-8 lg:hidden flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 grid place-items-center shadow-glow">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-ink-950" fill="currentColor"><path d="M12 2C9.5 5.5 7 9.2 7 13a5 5 0 0010 0c0-3.8-2.5-7.5-5-11z"/></svg>
        </div>
        <span class="font-display font-bold text-lg text-ink-900 tracking-tight">SIMONITORING BBM</span>
    </div>

    <p class="font-mono text-xs tracking-[0.22em] text-amber-600 mb-2 font-semibold">SELAMAT DATANG KEMBALI</p>
    <h2 class="font-display text-3xl font-bold text-ink-900 mb-1.5 tracking-tight">Masuk ke akun Anda</h2>
    <p class="text-sm text-slate-500 mb-8">Gunakan akun yang diberikan administrator untuk mengakses sistem.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-ink-900 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input-focus w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-500 @error('email') border-red-400 @enderror"
                   placeholder="nama@pertamina.test">
            @error('email') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-ink-900 mb-1.5">Password</label>
            <input type="password" name="password" required
                   class="input-focus w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-500 @error('password') border-red-400 @enderror"
                   placeholder="••••••••">
            @error('password') <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
            Ingat saya di perangkat ini
        </label>

        <button type="submit" class="w-full bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] text-white font-semibold rounded-xl py-3 text-sm transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
            Masuk ke Sistem <x-icon name="arrow-right" class="h-4 w-4"/>
        </button>
    </form>

    <div class="mt-8 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 ring-1 ring-amber-200/70 p-4 shadow-sm">
        <p class="text-xs font-bold text-amber-700 mb-2.5 font-mono tracking-wide flex items-center gap-1.5">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            AKUN DEMO (SEEDER)
        </p>
        <ul class="text-xs text-amber-800 space-y-1.5 font-mono">
            <li class="flex items-center gap-2"><span class="h-1 w-1 rounded-full bg-amber-500"></span>admin@pertamina.test</li>
            <li class="flex items-center gap-2"><span class="h-1 w-1 rounded-full bg-amber-500"></span>operator.depot@pertamina.test</li>
            <li class="flex items-center gap-2"><span class="h-1 w-1 rounded-full bg-amber-500"></span>operator.spbu@pertamina.test</li>
            <li class="flex items-center gap-2"><span class="h-1 w-1 rounded-full bg-amber-500"></span>pimpinan@pertamina.test</li>
        </ul>
        <p class="text-xs text-amber-700 mt-2.5 pt-2.5 border-t border-amber-200/70">Password untuk semua akun: <span class="font-mono font-bold">password123</span></p>
    </div>
@endsection
