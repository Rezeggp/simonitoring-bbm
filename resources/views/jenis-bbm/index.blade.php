@extends('layouts.app')
@section('title', 'Jenis BBM')
@section('heading', 'Jenis BBM')
@section('subheading', 'Kelola jenis produk BBM yang dipantau dalam sistem.')

@section('content')
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] overflow-hidden">
        <div class="p-5 flex items-center justify-end border-b border-black/5">
            <a href="{{ route('jenis-bbm.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
                <x-icon name="plus" class="h-4 w-4"/> Tambah Jenis BBM
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-3 font-medium">Kode</th>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Kategori</th>
                        <th class="px-5 py-3 font-medium">Harga / Liter</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($jenisBbms as $jenis)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-5 py-3.5 font-mono text-xs text-slate-600">{{ $jenis->kode }}</td>
                        <td class="px-5 py-3.5 font-medium text-ink-900">
                            <span class="inline-flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $jenis->warna_label }}"></span>
                                {{ $jenis->nama }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $jenis->kategori === 'gasoline' ? 'Bensin' : 'Solar/Diesel' }}</td>
                        <td class="px-5 py-3.5 font-mono text-slate-700">Rp {{ number_format($jenis->harga_per_liter, 0, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('jenis-bbm.edit', $jenis) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><x-icon name="edit" class="h-4 w-4"/></a>
                                <form method="POST" action="{{ route('jenis-bbm.destroy', $jenis) }}" onsubmit="return confirm('Hapus jenis BBM {{ $jenis->nama }}?');">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg hover:bg-red-50 text-red-500"><x-icon name="trash" class="h-4 w-4"/></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada jenis BBM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-black/5">{{ $jenisBbms->links() }}</div>
    </div>
@endsection
