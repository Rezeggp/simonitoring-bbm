@extends('layouts.app')
@section('title', 'Ubah Stok Depot')
@section('heading', 'Perbarui Stok Tangki')
@section('subheading', $stokDepot->depot->nama_depot.' · '.$stokDepot->jenisBbm->nama)

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-xl">
    <form method="POST" action="{{ route('stok-depot.update', $stokDepot) }}">
        @csrf @method('PUT')
        <div class="grid sm:grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Jumlah Stok (L)</label>
                <input type="number" step="0.01" name="jumlah_stok" value="{{ old('jumlah_stok', $stokDepot->jumlah_stok) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('jumlah_stok') border-red-400 @enderror">
                @error('jumlah_stok') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Kapasitas Tangki (L)</label>
                <input type="number" step="0.01" name="kapasitas_tangki" value="{{ old('kapasitas_tangki', $stokDepot->kapasitas_tangki) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('kapasitas_tangki') border-red-400 @enderror">
                @error('kapasitas_tangki') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Stok Minimum (L)</label>
                <input type="number" step="0.01" name="stok_minimum" value="{{ old('stok_minimum', $stokDepot->stok_minimum) }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
        </div>
        <div class="mt-7 flex items-center gap-3">
            <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Perubahan</button>
            <a href="{{ route('stok-depot.index', ['depot_id' => $stokDepot->depot_id]) }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
        </div>
    </form>
</div>
@endsection
