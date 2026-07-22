@extends('layouts.app')
@section('title', 'Distribusi BBM')
@section('heading', 'Distribusi BBM')
@section('subheading', 'Lacak status pengiriman BBM dari terminal ke SPBU.')

@section('content')
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] overflow-hidden">
        <div class="p-5 border-b border-black/5">
            <form method="GET" class="flex flex-wrap items-center gap-2.5">
                <div class="relative w-full sm:w-56">
                    <x-icon name="search" class="h-4 w-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"/>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode distribusi..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                </div>
                <select name="status" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua Status</option>
                    @foreach(['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'dikirim' => 'Dalam Pengiriman', 'diterima' => 'Diterima', 'dibatalkan' => 'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="depot_id" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua Terminal</option>
                    @foreach($depots as $depot)
                        <option value="{{ $depot->id }}" @selected(request('depot_id') == $depot->id)>{{ $depot->nama_depot }}</option>
                    @endforeach
                </select>
                <select name="spbu_id" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua SPBU</option>
                    @foreach($spbus as $spbu)
                        <option value="{{ $spbu->id }}" @selected(request('spbu_id') == $spbu->id)>{{ $spbu->nama_spbu }}</option>
                    @endforeach
                </select>
                <button class="text-sm font-medium text-slate-500 hover:text-ink-900 px-2">Terapkan</button>

                @if(in_array(auth()->user()->role, ['admin', 'operator_depot']))
                <a href="{{ route('distribusi.create') }}" class="ml-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
                    <x-icon name="plus" class="h-4 w-4"/> Buat Distribusi
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Terminal Asal</th>
                        <th class="px-5 py-3 font-medium">SPBU Tujuan</th>
                        <th class="px-5 py-3 font-medium">Jenis BBM</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($distribusis as $d)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $d->kode_distribusi }}</td>
                        <td class="px-5 py-3.5 text-ink-900">{{ $d->depot->nama_depot }}</td>
                        <td class="px-5 py-3.5 text-ink-900">{{ $d->spbu->nama_spbu }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $d->jenisBbm->nama }}</td>
                        <td class="px-5 py-3.5 font-mono text-slate-700">{{ number_format($d->jumlah_liter,0,',','.') }} L</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $d->tanggal_permintaan->translatedFormat('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full ring-1 whitespace-nowrap {{ $d->statusBadgeColor() }}">{{ $d->statusLabel() }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('distribusi.show', $d) }}" class="inline-flex items-center gap-1 text-xs font-medium text-amber-600 hover:text-amber-700">
                                Detail <x-icon name="arrow-right" class="h-3 w-3"/>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">Tidak ada data distribusi yang cocok dengan filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-black/5">{{ $distribusis->links() }}</div>
    </div>
@endsection
