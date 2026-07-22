@extends('layouts.app')
@section('title', 'Atur Tangki SPBU')
@section('heading', 'Pengaturan Tangki SPBU')
@section('subheading', $stokSpbu->spbu->nama_spbu.' · '.$stokSpbu->jenisBbm->nama)

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-xl">
    <div class="mb-5 text-sm bg-slate-50 rounded-xl p-4 text-slate-600">
        Jumlah stok saat ini: <span class="font-mono font-semibold text-ink-900">{{ number_format($stokSpbu->jumlah_stok,0,',','.') }} L</span>.
        Jumlah ini hanya berubah otomatis melalui proses distribusi, bukan diisi manual.
    </div>
    <form method="POST" action="{{ route('stok-spbu.update', $stokSpbu) }}">
        @csrf @method('PUT')
        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Kapasitas Tangki (L)</label>
                <input type="number" step="0.01" name="kapasitas_tangki" value="{{ old('kapasitas_tangki', $stokSpbu->kapasitas_tangki) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('kapasitas_tangki') border-red-400 @enderror">
                @error('kapasitas_tangki') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Stok Minimum (L)</label>
                <input type="number" step="0.01" name="stok_minimum" value="{{ old('stok_minimum', $stokSpbu->stok_minimum) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
        </div>
        <div class="mt-7 flex items-center gap-3">
            <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Perubahan</button>
            <a href="{{ route('stok-spbu.index', ['spbu_id' => $stokSpbu->spbu_id]) }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
        </div>
    </form>
</div>
@endsection
