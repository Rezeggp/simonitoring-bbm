@csrf
<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Kode SPBU</label>
        <input type="text" name="kode_spbu" value="{{ old('kode_spbu', $spbu->kode_spbu ?? '') }}" placeholder="31.123.01"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('kode_spbu') border-red-400 @enderror">
        @error('kode_spbu') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Status</label>
        <select name="status" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            <option value="aktif" @selected(old('status', $spbu->status ?? 'aktif') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $spbu->status ?? '') === 'nonaktif')>Nonaktif</option>
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink-900 mb-1.5">Nama SPBU</label>
    <input type="text" name="nama_spbu" value="{{ old('nama_spbu', $spbu->nama_spbu ?? '') }}" placeholder="SPBU Sudirman"
           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('nama_spbu') border-red-400 @enderror">
    @error('nama_spbu') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink-900 mb-1.5">Alamat</label>
    <input type="text" name="alamat" value="{{ old('alamat', $spbu->alamat ?? '') }}" placeholder="Jl. Jend. Sudirman No. 1"
           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('alamat') border-red-400 @enderror">
    @error('alamat') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid sm:grid-cols-3 gap-5 mt-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Wilayah</label>
        <input type="text" name="wilayah" value="{{ old('wilayah', $spbu->wilayah ?? '') }}"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Pemilik</label>
        <input type="text" name="pemilik" value="{{ old('pemilik', $spbu->pemilik ?? '') }}"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Telepon</label>
        <input type="text" name="telepon" value="{{ old('telepon', $spbu->telepon ?? '') }}"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
    </div>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Data</button>
    <a href="{{ route('spbus.index') }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
</div>
