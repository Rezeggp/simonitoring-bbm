@extends('layouts.app')
@section('title', 'Buat Distribusi')
@section('heading', 'Buat Permintaan Distribusi')
@section('subheading', 'Ajukan pengiriman BBM dari terminal ke SPBU tujuan.')

@section('content')
<div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 max-w-2xl">
    <form method="POST" action="{{ route('distribusi.store') }}">
        @csrf
        <div class="grid sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Terminal Asal (Depot)</label>
                <select name="depot_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('depot_id') border-red-400 @enderror">
                    <option value="">Pilih terminal...</option>
                    @foreach($depots as $depot)
                        <option value="{{ $depot->id }}" @selected(old('depot_id') == $depot->id)>{{ $depot->nama_depot }}</option>
                    @endforeach
                </select>
                @error('depot_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">SPBU Tujuan</label>
                <select name="spbu_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('spbu_id') border-red-400 @enderror">
                    <option value="">Pilih SPBU...</option>
                    @foreach($spbus as $spbu)
                        <option value="{{ $spbu->id }}" @selected(old('spbu_id') == $spbu->id)>{{ $spbu->nama_spbu }}</option>
                    @endforeach
                </select>
                @error('spbu_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5 mt-5">
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Jenis BBM</label>
                <select name="jenis_bbm_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('jenis_bbm_id') border-red-400 @enderror">
                    <option value="">Pilih jenis BBM...</option>
                    @foreach($jenisBbms as $jenis)
                        <option value="{{ $jenis->id }}" @selected(old('jenis_bbm_id') == $jenis->id)>{{ $jenis->nama }}</option>
                    @endforeach
                </select>
                @error('jenis_bbm_id') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Jumlah (Liter)</label>
                <input type="number" step="0.01" name="jumlah_liter" value="{{ old('jumlah_liter') }}" placeholder="8000"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('jumlah_liter') border-red-400 @enderror">
                @error('jumlah_liter') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-5 mt-5">
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">Nama Supir</label>
                <input type="text" name="nama_supir" value="{{ old('nama_supir') }}"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-900 mb-1.5">No. Polisi Kendaraan</label>
                <input type="text" name="no_polisi" value="{{ old('no_polisi') }}" placeholder="B 1234 ABC"
                       class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Tanggal Permintaan</label>
            <input type="datetime-local" name="tanggal_permintaan" value="{{ old('tanggal_permintaan', now()->format('Y-m-d\TH:i')) }}"
                   class="w-full sm:w-1/2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('tanggal_permintaan') border-red-400 @enderror">
            @error('tanggal_permintaan') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mt-5">
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Catatan (opsional)</label>
            <textarea name="catatan" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">{{ old('catatan') }}</textarea>
        </div>

        <div class="mt-7 flex items-center gap-3">
            <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Ajukan Distribusi</button>
            <a href="{{ route('distribusi.index') }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
        </div>
    </form>
</div>
@endsection
