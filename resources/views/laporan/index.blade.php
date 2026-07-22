@extends('layouts.app')
@section('title', 'Laporan')
@section('heading', 'Laporan Distribusi BBM')
@section('subheading', 'Rekap distribusi BBM berdasarkan periode dan filter yang dipilih.')

@section('content')

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-5 mb-5">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ $dariTanggal }}"
                       class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ $sampaiTanggal }}"
                       class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Terminal</label>
                <select name="depot_id" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua</option>
                    @foreach($depots as $depot)<option value="{{ $depot->id }}" @selected(request('depot_id')==$depot->id)>{{ $depot->nama_depot }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">SPBU</label>
                <select name="spbu_id" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua</option>
                    @foreach($spbus as $spbu)<option value="{{ $spbu->id }}" @selected(request('spbu_id')==$spbu->id)>{{ $spbu->nama_spbu }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Jenis BBM</label>
                <select name="jenis_bbm_id" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua</option>
                    @foreach($jenisBbms as $jenis)<option value="{{ $jenis->id }}" @selected(request('jenis_bbm_id')==$jenis->id)>{{ $jenis->nama }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Status</label>
                <select name="status" class="rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                    <option value="">Semua</option>
                    @foreach(['menunggu'=>'Menunggu','diproses'=>'Diproses','dikirim'=>'Dikirim','diterima'=>'Diterima','dibatalkan'=>'Dibatalkan'] as $val=>$label)
                        <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        <div class="bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04]">
            <p class="text-xs text-slate-500 mb-2">Total Liter Terkirim</p>
            <p class="font-display text-2xl font-semibold text-ink-900 font-mono">{{ number_format($totalLiterTerkirim,0,',','.') }} L</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04]">
            <p class="text-xs text-slate-500 mb-2">Total Transaksi</p>
            <p class="font-display text-2xl font-semibold text-ink-900">{{ $totalDistribusi }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04]">
            <p class="text-xs text-slate-500 mb-2">Berhasil Diterima</p>
            <p class="font-display text-2xl font-semibold text-emerald-600">{{ $totalDiterima }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04]">
            <p class="text-xs text-slate-500 mb-2">Dibatalkan</p>
            <p class="font-display text-2xl font-semibold text-red-500">{{ $totalDibatalkan }}</p>
        </div>
    </div>

    {{-- Rekap per jenis --}}
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6 mb-5">
        <h3 class="font-display font-semibold text-ink-900 mb-4">Rekap per Jenis BBM</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($rekapPerJenis as $r)
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-sm font-medium text-ink-900 mb-1">{{ $r['nama'] }}</p>
                <p class="font-mono text-lg font-semibold text-amber-600">{{ number_format($r['total_liter'],0,',','.') }} L</p>
                <p class="text-xs text-slate-500">{{ $r['jumlah_transaksi'] }} transaksi</p>
            </div>
            @empty
            <p class="text-sm text-slate-400 col-span-full">Tidak ada data pada periode ini.</p>
            @endforelse
        </div>
    </div>

    {{-- Tabel distribusi + tombol export --}}
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] overflow-hidden mb-5">
        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-black/5">
            <h3 class="font-display font-semibold text-ink-900">Detail Distribusi</h3>
            <a href="{{ route('export.distribusi-csv', request()->all()) }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 font-medium">Terminal</th>
                        <th class="px-5 py-3 font-medium">SPBU</th>
                        <th class="px-5 py-3 font-medium">Jenis BBM</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($distribusis as $d)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $d->kode_distribusi }}</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $d->tanggal_permintaan->format('d/m/Y') }}</td>
                        <td class="px-5 py-3.5 text-ink-900">{{ $d->depot->nama_depot }}</td>
                        <td class="px-5 py-3.5 text-ink-900">{{ $d->spbu->nama_spbu }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $d->jenisBbm->nama }}</td>
                        <td class="px-5 py-3.5 font-mono text-slate-700">{{ number_format($d->jumlah_liter,0,',','.') }} L</td>
                        <td class="px-5 py-3.5">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full ring-1 whitespace-nowrap {{ $d->statusBadgeColor() }}">{{ $d->statusLabel() }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">Tidak ada data pada periode dan filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PANEL BACKUP & EXPORT DATA --}}
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-amber-200 p-6">
        <div class="flex items-center gap-2 mb-2">
            <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7h16"/>
            </svg>
            <h3 class="font-display font-semibold text-ink-900">Backup & Export Data</h3>
        </div>
        <p class="text-sm text-slate-500 mb-5">
            Unduh data sistem untuk keperluan <span class="font-semibold text-ink-900">backup</span>,
            <span class="font-semibold text-ink-900">pemulihan data</span>, atau analisis lebih lanjut.
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('export.stok-depot-csv') }}"
               class="flex items-start gap-4 rounded-xl ring-1 ring-black/10 p-4 hover:bg-slate-50 transition group">
                <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 grid place-items-center shrink-0 group-hover:bg-blue-100 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C9.5 5.5 7 9.2 7 13a5 5 0 0010 0c0-3.8-2.5-7.5-5-11z"/></svg>
                </div>
                <div>
                    <p class="font-medium text-ink-900 text-sm">Stok Terminal BBM</p>
                    <p class="text-xs text-slate-500 mt-0.5">Export data stok semua terminal ke CSV</p>
                    <span class="inline-block mt-2 text-[11px] font-mono font-medium text-blue-600">↓ download .csv</span>
                </div>
            </a>

            <a href="{{ route('export.stok-spbu-csv') }}"
               class="flex items-start gap-4 rounded-xl ring-1 ring-black/10 p-4 hover:bg-slate-50 transition group">
                <div class="h-10 w-10 rounded-xl bg-violet-50 text-violet-600 grid place-items-center shrink-0 group-hover:bg-violet-100 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <div>
                    <p class="font-medium text-ink-900 text-sm">Stok SPBU</p>
                    <p class="text-xs text-slate-500 mt-0.5">Export data stok semua SPBU ke CSV</p>
                    <span class="inline-block mt-2 text-[11px] font-mono font-medium text-violet-600">↓ download .csv</span>
                </div>
            </a>

            @if(auth()->user()->isAdmin())
            <a href="{{ route('export.backup-database') }}"
               class="flex items-start gap-4 rounded-xl ring-1 ring-amber-200 bg-amber-50/40 p-4 hover:bg-amber-50 transition group">
                <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-700 grid place-items-center shrink-0 group-hover:bg-amber-200 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7M4 7c0-2 1.5-3 3.5-3h9c2 0 3.5 1 3.5 3M4 7h16M10 12h4"/></svg>
                </div>
                <div>
                    <p class="font-medium text-ink-900 text-sm">Backup Database</p>
                    <p class="text-xs text-slate-500 mt-0.5">Download file database SQLite penuh — hanya Admin</p>
                    <span class="inline-block mt-2 text-[11px] font-mono font-medium text-amber-700">↓ download .sqlite</span>
                </div>
            </a>
            @endif
        </div>

        <div class="mt-4 rounded-xl bg-slate-50 p-4 text-xs text-slate-500 leading-relaxed">
            <span class="font-semibold text-ink-900">Cara Restore Database:</span>
            Ganti file <span class="font-mono bg-slate-100 px-1 rounded">database/database.sqlite</span>
            di folder project dengan file backup yang telah diunduh,
            lalu jalankan <span class="font-mono bg-slate-100 px-1 rounded">php artisan cache:clear</span> di terminal.
        </div>
    </div>

@endsection
