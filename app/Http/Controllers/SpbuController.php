<?php

namespace App\Http\Controllers;

use App\Models\Spbu;
use Illuminate\Http\Request;

class SpbuController extends Controller
{
    public function index(Request $request)
    {
        $spbus = Spbu::withCount('stoks')
            ->when($request->search, fn ($q) => $q->where('nama_spbu', 'like', '%'.$request->search.'%')
                ->orWhere('kode_spbu', 'like', '%'.$request->search.'%'))
            ->orderBy('nama_spbu')
            ->paginate(10)
            ->withQueryString();

        return view('spbus.index', compact('spbus'));
    }

    public function create()
    {
        return view('spbus.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Spbu::create($data);

        return redirect()->route('spbus.index')->with('success', 'SPBU baru berhasil ditambahkan.');
    }

    public function edit(Spbu $spbu)
    {
        return view('spbus.edit', compact('spbu'));
    }

    public function update(Request $request, Spbu $spbu)
    {
        $data = $this->validateData($request, $spbu->id);
        $spbu->update($data);

        return redirect()->route('spbus.index')->with('success', 'Data SPBU berhasil diperbarui.');
    }

    public function destroy(Spbu $spbu)
    {
        $spbu->delete();

        return redirect()->route('spbus.index')->with('success', 'Data SPBU berhasil dihapus.');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_spbu' => ['required', 'string', 'max:20', 'unique:spbus,kode_spbu,'.($ignoreId ?? 'NULL')],
            'nama_spbu' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string', 'max:255'],
            'wilayah' => ['nullable', 'string', 'max:100'],
            'pemilik' => ['nullable', 'string', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'kode_spbu.required' => 'Kode SPBU wajib diisi.',
            'kode_spbu.unique' => 'Kode SPBU sudah digunakan.',
            'nama_spbu.required' => 'Nama SPBU wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);
    }
}
