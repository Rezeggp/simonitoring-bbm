@extends('layouts.app')
@section('title', 'Detail Distribusi')
@section('heading', $distribusi->kode_distribusi)
@section('subheading', 'Detail dan riwayat status distribusi BBM.')

@section('content')
<div class="grid lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6">
        <div class="flex items-center justify-between mb-6">
            <span class="text-[11px] font-medium px-2.5 py-1 rounded-full ring-1 {{ $distribusi->statusBadgeColor() }}">{{ $distribusi->statusLabel() }}</span>
            @if($distribusi->status === 'menunggu' && in_array(auth()->user()->role, ['admin','operator_depot']))
            <form method="POST" action="{{ route('distribusi.destroy', $distribusi) }}" onsubmit="return confirm('Hapus permintaan distribusi ini?');">
                @csrf @method('DELETE')
                <button class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 hover:text-red-600">
                    <x-icon name="trash" class="h-3.5 w-3.5"/> Hapus Permintaan
                </button>
            </form>
            @endif
        </div>

        {{-- Timeline status --}}
        <div class="flex items-center mb-8">
            @php
                $steps = ['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'diterima' => 'Diterima'];
                $urutan = array_keys($steps);
                $posisiSaatIni = $distribusi->status === 'dibatalkan' ? -1 : array_search($distribusi->status, $urutan);
            @endphp
            @foreach($steps as $key => $label)
                @php $idx = array_search($key, $urutan); @endphp
                <div class="flex-1 flex items-center">
                    <div class="flex flex-col items-center gap-2 {{ $idx === 0 ? '' : 'flex-1' }}">
                        <div class="h-8 w-8 rounded-full grid place-items-center text-xs font-semibold {{ $idx <= $posisiSaatIni ? 'bg-ink-950 text-white' : 'bg-slate-100 text-slate-400' }}">
                            @if($idx < $posisiSaatIni || $idx === $posisiSaatIni) <x-icon name="check" class="h-4 w-4"/> @else {{ $idx + 1 }} @endif
                        </div>
                        <span class="text-[11px] font-medium {{ $idx <= $posisiSaatIni ? 'text-ink-900' : 'text-slate-400' }}">{{ $label }}</span>
                    </div>
                    @if($idx < count($urutan) - 1)
                        <div class="h-0.5 flex-1 {{ $idx < $posisiSaatIni ? 'bg-ink-950' : 'bg-slate-100' }} mx-1 -mt-5"></div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($distribusi->status === 'dibatalkan')
            <div class="mb-6 rounded-xl bg-red-50 ring-1 ring-red-200 p-3 text-sm text-red-700">Permintaan distribusi ini telah dibatalkan.</div>
        @endif

        <dl class="grid sm:grid-cols-2 gap-5 text-sm">
            <div><dt class="text-slate-500 mb-1">Terminal Asal</dt><dd class="font-medium text-ink-900">{{ $distribusi->depot->nama_depot }}</dd></div>
            <div><dt class="text-slate-500 mb-1">SPBU Tujuan</dt><dd class="font-medium text-ink-900">{{ $distribusi->spbu->nama_spbu }}</dd></div>
            <div><dt class="text-slate-500 mb-1">Jenis BBM</dt><dd class="font-medium text-ink-900">{{ $distribusi->jenisBbm->nama }}</dd></div>
            <div><dt class="text-slate-500 mb-1">Jumlah</dt><dd class="font-mono font-medium text-ink-900">{{ number_format($distribusi->jumlah_liter,0,',','.') }} Liter</dd></div>
            <div><dt class="text-slate-500 mb-1">Nama Supir</dt><dd class="font-medium text-ink-900">{{ $distribusi->nama_supir ?: '—' }}</dd></div>
            <div><dt class="text-slate-500 mb-1">No. Polisi</dt><dd class="font-mono font-medium text-ink-900">{{ $distribusi->no_polisi ?: '—' }}</dd></div>
            <div><dt class="text-slate-500 mb-1">Dibuat Oleh</dt><dd class="font-medium text-ink-900">{{ $distribusi->dibuatOleh->name ?? '—' }}</dd></div>
            <div><dt class="text-slate-500 mb-1">Tanggal Permintaan</dt><dd class="font-medium text-ink-900">{{ $distribusi->tanggal_permintaan->translatedFormat('d F Y, H:i') }}</dd></div>
        </dl>

        @if($distribusi->catatan)
        <div class="mt-5 pt-5 border-t border-black/5">
            <dt class="text-slate-500 mb-1 text-sm">Catatan</dt>
            <dd class="text-sm text-ink-900">{{ $distribusi->catatan }}</dd>
        </div>
        @endif
    </div>

    <div class="space-y-5">
        {{-- Riwayat waktu --}}
        <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6">
            <h3 class="font-display font-semibold text-ink-900 mb-4">Riwayat Waktu</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between"><span class="text-slate-500">Permintaan</span><span class="font-mono">{{ $distribusi->tanggal_permintaan->format('d/m/Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Diproses</span><span class="font-mono">{{ $distribusi->tanggal_proses?->format('d/m/Y H:i') ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Dikirim</span><span class="font-mono">{{ $distribusi->tanggal_kirim?->format('d/m/Y H:i') ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Diterima</span><span class="font-mono">{{ $distribusi->tanggal_terima?->format('d/m/Y H:i') ?? '—' }}</span></div>
            </div>
        </div>

        {{-- Aksi workflow --}}
        @if(in_array(auth()->user()->role, ['admin','operator_depot']))
        <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] p-6">
            <h3 class="font-display font-semibold text-ink-900 mb-4">Perbarui Status</h3>

            @if($distribusi->status === 'menunggu')
                <form method="POST" action="{{ route('distribusi.update-status', $distribusi) }}" class="space-y-2">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="diproses">
                    <button class="w-full bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-xl py-2.5">Proses Permintaan</button>
                </form>
                <form method="POST" action="{{ route('distribusi.update-status', $distribusi) }}" class="mt-2" onsubmit="return confirm('Batalkan permintaan distribusi ini?');">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dibatalkan">
                    <button class="w-full bg-white ring-1 ring-red-200 text-red-600 hover:bg-red-50 text-sm font-medium rounded-xl py-2.5">Batalkan</button>
                </form>
            @elseif($distribusi->status === 'diproses')
                <form method="POST" action="{{ route('distribusi.update-status', $distribusi) }}" class="space-y-2">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dikirim">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl py-2.5">Kirim BBM (kurangi stok depot)</button>
                </form>
                <form method="POST" action="{{ route('distribusi.update-status', $distribusi) }}" class="mt-2" onsubmit="return confirm('Batalkan permintaan distribusi ini?');">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dibatalkan">
                    <button class="w-full bg-white ring-1 ring-red-200 text-red-600 hover:bg-red-50 text-sm font-medium rounded-xl py-2.5">Batalkan</button>
                </form>
            @elseif($distribusi->status === 'dikirim')
                <form method="POST" action="{{ route('distribusi.update-status', $distribusi) }}" class="space-y-2">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="diterima">
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl py-2.5">Konfirmasi Diterima SPBU (tambah stok SPBU)</button>
                </form>
            @else
                <p class="text-sm text-slate-400">Tidak ada aksi lebih lanjut untuk status ini.</p>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
