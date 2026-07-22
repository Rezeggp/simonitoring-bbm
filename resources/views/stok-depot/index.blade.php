@extends('layouts.app')
@section('title', 'Stok Terminal BBM')
@section('heading', 'Stok Terminal BBM (Depot)')
@section('subheading', 'Pantau dan kelola volume stok di setiap tangki terminal.')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <form method="GET" class="flex items-center gap-2">
            <label class="text-sm text-slate-500">Pilih Terminal:</label>
            <select name="depot_id" onchange="this.form.submit()" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                @foreach($depots as $depot)
                    <option value="{{ $depot->id }}" @selected($depotId == $depot->id)>{{ $depot->nama_depot }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('stok-depot.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
            <x-icon name="plus" class="h-4 w-4"/> Tambah Data Tangki
        </a>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($stoks as $stok)
        <div class="bg-white rounded-2xl p-5 shadow-card ring-1 {{ $stok->isMenipis() ? 'ring-red-200' : 'ring-black/5' }}">
            <div class="flex items-center gap-4">
                <x-gauge :percentage="$stok->persentase" :size="64" :critical="$stok->isMenipis()"/>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="h-2 w-2 rounded-full" style="background-color: {{ $stok->jenisBbm->warna_label }}"></span>
                        <p class="font-display font-semibold text-ink-900 truncate">{{ $stok->jenisBbm->nama }}</p>
                    </div>
                    <p class="text-xs text-slate-500 font-mono">{{ number_format($stok->jumlah_stok,0,',','.') }} / {{ number_format($stok->kapasitas_tangki,0,',','.') }} L</p>
                    @if($stok->isMenipis())
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-red-600 mt-1"><x-icon name="alert" class="h-3 w-3"/> Stok menipis</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-black/5">
                <p class="text-xs text-slate-400">Min. stok: {{ number_format($stok->stok_minimum,0,',','.') }} L</p>
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('stok-depot.edit', $stok) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><x-icon name="edit" class="h-4 w-4"/></a>
                    <form method="POST" action="{{ route('stok-depot.destroy', $stok) }}" onsubmit="return confirm('Hapus data tangki ini?');">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-lg hover:bg-red-50 text-red-500"><x-icon name="trash" class="h-4 w-4"/></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl p-10 text-center text-slate-400 ring-1 ring-black/5">Belum ada data stok untuk terminal ini.</div>
        @endforelse
    </div>
@endsection
