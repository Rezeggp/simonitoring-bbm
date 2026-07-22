@csrf
<div x-data="{ role: '{{ old('role', $user->role ?? 'operator_depot') }}' }">
    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('name') border-red-400 @enderror">
            @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('email') border-red-400 @enderror">
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5 mt-5">
        <div>
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }}</label>
            <input type="password" name="password"
                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 @error('password') border-red-400 @enderror">
            @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-ink-900 mb-1.5">Peran (Role)</label>
            <select name="role" x-model="role" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
                <option value="admin">Admin</option>
                <option value="operator_depot">Operator Terminal (Depot)</option>
                <option value="operator_spbu">Operator SPBU</option>
                <option value="pimpinan">Pimpinan</option>
            </select>
        </div>
    </div>

    <div class="mt-5" x-show="role === 'operator_depot'" x-cloak>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Penempatan Terminal</label>
        <select name="depot_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            <option value="">Pilih terminal...</option>
            @foreach($depots as $depot)
                <option value="{{ $depot->id }}" @selected(old('depot_id', $user->depot_id ?? '') == $depot->id)>{{ $depot->nama_depot }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-5" x-show="role === 'operator_spbu'" x-cloak>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Penempatan SPBU</label>
        <select name="spbu_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40">
            <option value="">Pilih SPBU...</option>
            @foreach($spbus as $spbu)
                <option value="{{ $spbu->id }}" @selected(old('spbu_id', $user->spbu_id ?? '') == $spbu->id)>{{ $spbu->nama_spbu }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Data</button>
    <a href="{{ route('users.index') }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
</div>
