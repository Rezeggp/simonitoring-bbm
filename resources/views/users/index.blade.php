@extends('layouts.app')
@section('title', 'Pengguna')
@section('heading', 'Manajemen Pengguna')
@section('subheading', 'Kelola akun pengguna dan hak akses peran (role) sistem.')

@section('content')
    <div class="bg-white rounded-2xl shadow-card ring-1 ring-black/[0.04] overflow-hidden">
        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-black/5">
            <form method="GET" class="relative w-full sm:w-72">
                <x-icon name="search" class="h-4 w-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"/>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            </form>
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-4 py-2.5 transition">
                <x-icon name="plus" class="h-4 w-4"/> Tambah Pengguna
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wide bg-slate-50">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Peran</th>
                        <th class="px-5 py-3 font-medium">Penempatan</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-amber-50/30 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-amber-500 grid place-items-center font-display font-semibold text-ink-950 text-xs">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                                <span class="font-medium text-ink-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full ring-1 bg-slate-100 text-slate-600 ring-slate-200">{{ $user->roleLabel() }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $user->depot->nama_depot ?? $user->spbu->nama_spbu ?? '—' }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('users.edit', $user) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><x-icon name="edit" class="h-4 w-4"/></a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?');">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg hover:bg-red-50 text-red-500"><x-icon name="trash" class="h-4 w-4"/></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada data pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-black/5">{{ $users->links() }}</div>
    </div>
@endsection
