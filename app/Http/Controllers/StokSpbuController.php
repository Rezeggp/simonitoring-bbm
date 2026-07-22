<?php

namespace App\Http\Controllers;

use App\Models\Spbu;
use App\Models\StokSpbu;
use Illuminate\Http\Request;

class StokSpbuController extends Controller
{
    public function index(Request $request)
    {
        $spbus = Spbu::orderBy('nama_spbu')->get();
        $spbuId = $request->spbu_id ?: $spbus->first()?->id;

        $stoks = StokSpbu::with(['spbu', 'jenisBbm'])
            ->when($spbuId, fn ($q) => $q->where('spbu_id', $spbuId))
            ->get();

        return view('stok-spbu.index', compact('spbus', 'stoks', 'spbuId'));
    }

    public function edit(StokSpbu $stokSpbu)
    {
        return view('stok-spbu.edit', compact('stokSpbu'));
    }

    public function update(Request $request, StokSpbu $stokSpbu)
    {
        $data = $request->validate([
            'kapasitas_tangki' => ['required', 'numeric', 'min:1'],
            'stok_minimum' => ['required', 'numeric', 'min:0'],
        ], [
            'kapasitas_tangki.required' => 'Kapasitas tangki wajib diisi.',
        ]);

        $stokSpbu->update($data);

        return redirect()->route('stok-spbu.index', ['spbu_id' => $stokSpbu->spbu_id])->with('success', 'Pengaturan tangki SPBU berhasil diperbarui.');
    }
}
