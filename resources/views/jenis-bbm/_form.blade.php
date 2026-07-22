@csrf
<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Kode</label>
        <input type="text" name="kode" value="{{ old('kode', $jenisBbm->kode ?? '') }}" placeholder="PRTLT"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('kode') border-red-400 @enderror">
        @error('kode') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Kategori</label>
        <select name="kategori" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            <option value="gasoline" @selected(old('kategori', $jenisBbm->kategori ?? '') === 'gasoline')>Bensin (Gasoline)</option>
            <option value="diesel" @selected(old('kategori', $jenisBbm->kategori ?? '') === 'diesel')>Solar / Diesel</option>
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink-900 mb-1.5">Nama Produk</label>
    <input type="text" name="nama" value="{{ old('nama', $jenisBbm->nama ?? '') }}" placeholder="Pertalite"
           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('nama') border-red-400 @enderror">
    @error('nama') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Harga per Liter (Rp)</label>
        <input type="number" name="harga_per_liter" value="{{ old('harga_per_liter', $jenisBbm->harga_per_liter ?? '') }}" placeholder="10000"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('harga_per_liter') border-red-400 @enderror">
        @error('harga_per_liter') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Warna Label</label>
        <input type="color" name="warna_label" value="{{ old('warna_label', $jenisBbm->warna_label ?? '#F0973A') }}"
               class="w-full h-[42px] rounded-xl border border-slate-200 px-2 py-1 text-sm">
    </div>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Data</button>
    <a href="{{ route('jenis-bbm.index') }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
</div>
