@extends('layouts.app')
@section('title', 'SPBU')
@section('heading', 'Data SPBU')
@section('subheading', 'Kelola data master SPBU tujuan distribusi.')

@section('content')
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] overflow-hidden">
        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-black/5">
            <form method="GET" class="relative w-full sm:w-72">
                <x-icon name="search" class="h-4 w-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"/>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode SPBU..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            </form>
            <a href="{{ route('spbus.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
                <x-icon name="plus" class="h-4 w-4"/> Tambah SPBU
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Nama SPBU</th>
                        <th class="px-5 py-3 font-medium">Wilayah</th>
                        <th class="px-5 py-3 font-medium">Pemilik</th>
                        <th class="px-5 py-3 font-medium">Jenis BBM</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($spbus as $spbu)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $spbu->kode_spbu }}</td>
                        <td class="px-5 py-3.5 font-medium text-ink-900">{{ $spbu->nama_spbu }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $spbu->wilayah ?: '—' }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $spbu->pemilik ?: '—' }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $spbu->stoks_count }} jenis</td>
                        <td class="px-5 py-3.5">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full ring-1 {{ $spbu->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-slate-100 text-slate-500 ring-slate-200' }}">
                                {{ ucfirst($spbu->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('spbus.edit', $spbu) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><x-icon name="edit" class="h-4 w-4"/></a>
                                <form method="POST" action="{{ route('spbus.destroy', $spbu) }}" onsubmit="return confirm('Hapus data SPBU {{ $spbu->nama_spbu }}?');">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg hover:bg-red-50 text-red-500"><x-icon name="trash" class="h-4 w-4"/></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">Belum ada data SPBU.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-black/5">{{ $spbus->links() }}</div>
    </div>
@endsection
