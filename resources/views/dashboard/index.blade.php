@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard Monitoring')
@section('subheading', 'Ringkasan distribusi dan ketersediaan stok BBM hari ini.')

@section('content')

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="kpi-card text-blue-600 bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">Terminal BBM Aktif</span>
                <span class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 grid place-items-center shadow-sm"><x-icon name="building" class="h-4 w-4"/></span>
            </div>
            <p class="font-display text-3xl font-bold text-ink-900 tracking-tight">{{ $totalDepot }}</p>
        </div>
        <div class="kpi-card text-violet-600 bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">SPBU Aktif</span>
                <span class="h-9 w-9 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 text-violet-600 grid place-items-center shadow-sm"><x-icon name="pin" class="h-4 w-4"/></span>
            </div>
            <p class="font-display text-3xl font-bold text-ink-900 tracking-tight">{{ $totalSpbu }}</p>
        </div>
        <div class="kpi-card text-amber-600 bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">Distribusi Hari Ini</span>
                <span class="h-9 w-9 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 text-amber-600 grid place-items-center shadow-sm"><x-icon name="truck" class="h-4 w-4"/></span>
            </div>
            <p class="font-display text-3xl font-bold text-ink-900 tracking-tight">{{ $distribusiHariIni }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $distribusiDalamProses }} sedang dalam proses</p>
        </div>
        <div class="kpi-card text-emerald-600 bg-white rounded-2xl p-5 shadow-card ring-1 ring-black/[0.04] hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">Total Stok Tersimpan</span>
                <span class="h-9 w-9 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 grid place-items-center shadow-sm"><x-icon name="droplet" class="h-4 w-4"/></span>
            </div>
            <p class="font-display text-2xl font-bold text-ink-900 font-mono tracking-tight">{{ number_format($totalStokDepot + $totalStokSpbu, 0, ',', '.') }} L</p>
            <p class="text-xs text-slate-400 mt-1">Depot + SPBU</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-5 mb-6">
        {{-- Chart distribusi 7 hari --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-card ring-1 ring-black/[0.04]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-display font-bold text-ink-900 tracking-tight">Tren Distribusi 7 Hari Terakhir</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Jumlah pengiriman dan volume liter terkirim</p>
                </div>
                <span class="h-8 w-8 rounded-lg bg-ink-950 text-amber-400 grid place-items-center"><x-icon name="chart" class="h-4 w-4"/></span>
            </div>
            <canvas id="chartDistribusi" height="140"></canvas>
        </div>

        {{-- Chart status distribusi --}}
        <div class="bg-white rounded-2xl p-6 shadow-card ring-1 ring-black/[0.04]">
            <h3 class="font-display font-bold text-ink-900 mb-1 tracking-tight">Status Distribusi</h3>
            <p class="text-xs text-slate-500 mb-5">Seluruh data tercatat</p>
            <canvas id="chartStatus" height="200"></canvas>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-5 mb-6">
        {{-- Stok per jenis BBM --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-card ring-1 ring-black/[0.04]">
            <h3 class="font-display font-bold text-ink-900 mb-1 tracking-tight">Stok per Jenis BBM</h3>
            <p class="text-xs text-slate-500 mb-5">Perbandingan volume stok di Terminal vs SPBU (liter)</p>
            <canvas id="chartJenis" height="160"></canvas>
        </div>

        {{-- Distribusi terbaru --}}
        <div class="bg-white rounded-2xl p-6 shadow-card ring-1 ring-black/[0.04]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-bold text-ink-900 tracking-tight">Distribusi Terbaru</h3>
                <span class="h-7 w-7 rounded-lg bg-ink-950 text-amber-400 grid place-items-center"><x-icon name="truck" class="h-3.5 w-3.5"/></span>
            </div>
            <div class="space-y-3.5">
                @forelse($distribusiTerbaru as $d)
                    <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-ink-900 truncate">{{ $d->spbu->nama_spbu }}</p>
                            <p class="text-xs text-slate-500 font-mono truncate">{{ $d->kode_distribusi }}</p>
                        </div>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full ring-1 whitespace-nowrap {{ $d->statusBadgeColor() }}">{{ $d->statusLabel() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada data distribusi.</p>
                @endforelse
            </div>
            <a href="{{ route('distribusi.index') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-amber-600 hover:text-amber-700 hover:gap-2.5 transition-all">
                Lihat semua distribusi <x-icon name="arrow-right" class="h-3.5 w-3.5"/>
            </a>
        </div>
    </div>

    {{-- Peringatan stok menipis --}}
    @if($stokMenipisDepot->count() || $stokMenipisSpbu->count())
    <div class="bg-gradient-to-br from-white to-red-50/40 rounded-2xl p-6 shadow-card ring-1 ring-red-200/70 relative overflow-hidden">
        <div class="absolute top-0 right-0 h-40 w-40 bg-red-400/10 rounded-full blur-3xl -z-0"></div>
        <div class="flex items-center gap-2.5 mb-5 relative z-10">
            <span class="h-9 w-9 rounded-xl bg-red-100 text-red-600 grid place-items-center shadow-sm">
                <x-icon name="alert" class="h-4.5 w-4.5"/>
            </span>
            <h3 class="font-display font-bold text-ink-900 tracking-tight">Peringatan Stok Menipis</h3>
        </div>
        <div class="grid lg:grid-cols-2 gap-6 relative z-10">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Terminal BBM</p>
                <div class="space-y-3">
                    @forelse($stokMenipisDepot as $s)
                        <div class="flex items-center gap-3 rounded-xl bg-white ring-1 ring-red-100 p-3 shadow-sm hover:shadow-md transition-shadow">
                            <x-gauge :percentage="$s->persentase" :size="48" critical/>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-ink-900 truncate">{{ $s->depot->nama_depot }}</p>
                                <p class="text-xs text-slate-500">{{ $s->jenisBbm->nama }} · {{ number_format($s->jumlah_stok,0,',','.') }} L tersisa</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Semua stok terminal dalam batas aman.</p>
                    @endforelse
                </div>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">SPBU</p>
                <div class="space-y-3">
                    @forelse($stokMenipisSpbu as $s)
                        <div class="flex items-center gap-3 rounded-xl bg-white ring-1 ring-red-100 p-3 shadow-sm hover:shadow-md transition-shadow">
                            <x-gauge :percentage="$s->persentase" :size="48" critical/>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-ink-900 truncate">{{ $s->spbu->nama_spbu }}</p>
                                <p class="text-xs text-slate-500">{{ $s->jenisBbm->nama }} · {{ number_format($s->jumlah_stok,0,',','.') }} L tersisa</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Semua stok SPBU dalam batas aman.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

<style>canvas{max-height:280px}</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inkMuted = '#94A3B8';

    new Chart(document.getElementById('chartDistribusi'), {
        type: 'bar',
        data: {
            labels: @json($distribusi7Hari->pluck('tanggal')),
            datasets: [
                {
                    label: 'Jumlah Pengiriman',
                    data: @json($distribusi7Hari->pluck('jumlah')),
                    backgroundColor: (ctx) => {
                        const g = ctx.chart.ctx.createLinearGradient(0,0,0,220);
                        g.addColorStop(0,'#FB923C'); g.addColorStop(1,'#F2790F');
                        return g;
                    },
                    borderRadius: 8,
                    yAxisID: 'y',
                },
                {
                    label: 'Liter Terkirim',
                    data: @json($distribusi7Hari->pluck('liter')),
                    type: 'line',
                    borderColor: '#0D1219',
                    backgroundColor: '#0D1219',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#0D1219',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    yAxisID: 'y1',
                },
            ],
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { beginAtZero: true, position: 'left', grid: { color: '#F1EFE9' }, ticks: { color: inkMuted, font:{size:11} } },
                y1: { beginAtZero: true, position: 'right', grid: { display: false }, ticks: { color: inkMuted, font:{size:11} } },
                x: { grid: { display: false }, ticks: { color: inkMuted, font:{size:11} } },
            },
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, color: '#475569', font:{size:11,weight:600} } } },
        },
    });

    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Diproses', 'Dikirim', 'Diterima', 'Dibatalkan'],
            datasets: [{
                data: [
                    {{ $distribusiPerStatus['menunggu'] ?? 0 }},
                    {{ $distribusiPerStatus['diproses'] ?? 0 }},
                    {{ $distribusiPerStatus['dikirim'] ?? 0 }},
                    {{ $distribusiPerStatus['diterima'] ?? 0 }},
                    {{ $distribusiPerStatus['dibatalkan'] ?? 0 }},
                ],
                backgroundColor: ['#CBD5E1', '#FBBF24', '#3B82F6', '#10B981', '#EF4444'],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 6,
            }],
        },
        options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11, weight:600 }, color: '#475569' } } }, cutout: '68%' },
    });

    new Chart(document.getElementById('chartJenis'), {
        type: 'bar',
        data: {
            labels: @json($stokPerJenis->pluck('nama')),
            datasets: [
                { label: 'Stok Terminal', data: @json($stokPerJenis->pluck('depot')), backgroundColor: '#0D1219', borderRadius: 8 },
                { label: 'Stok SPBU', data: @json($stokPerJenis->pluck('spbu')), backgroundColor: '#F2790F', borderRadius: 8 },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: '#F1EFE9' }, ticks: { color: inkMuted, font:{size:11} } },
                x: { grid: { display: false }, ticks: { color: inkMuted, font:{size:11} } },
            },
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, color: '#475569', font:{size:11,weight:600} } } },
        },
    });
});
</script>
@endsection
