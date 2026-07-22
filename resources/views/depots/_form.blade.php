@csrf
<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Kode Depot</label>
        <input type="text" name="kode_depot" value="{{ old('kode_depot', $depot->kode_depot ?? '') }}" placeholder="TBBM-XXX"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('kode_depot') border-red-400 @enderror">
        @error('kode_depot') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Status</label>
        <select name="status" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            <option value="aktif" @selected(old('status', $depot->status ?? 'aktif') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $depot->status ?? '') === 'nonaktif')>Nonaktif</option>
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink-900 mb-1.5">Nama Terminal BBM</label>
    <input type="text" name="nama_depot" value="{{ old('nama_depot', $depot->nama_depot ?? '') }}" placeholder="Terminal BBM Plumpang"
           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('nama_depot') border-red-400 @enderror">
    @error('nama_depot') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-ink-900 mb-1.5">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $depot->lokasi ?? '') }}" placeholder="Jakarta Utara, DKI Jakarta"
           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 @error('lokasi') border-red-400 @enderror">
    @error('lokasi') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Penanggung Jawab</label>
        <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $depot->penanggung_jawab ?? '') }}"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-ink-900 mb-1.5">Telepon</label>
        <input type="text" name="telepon" value="{{ old('telepon', $depot->telepon ?? '') }}"
               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
    </div>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="bg-gradient-to-r from-ink-950 to-ink-900 hover:from-ink-900 hover:to-[#161D26] hover:-translate-y-0.5 hover:shadow-lg transition-all text-white text-sm font-medium rounded-xl px-5 py-2.5 transition">Simpan Data</button>
    <a href="{{ route('depots.index') }}" class="text-sm font-medium text-slate-500 hover:text-ink-900">Batal</a>
</div>
