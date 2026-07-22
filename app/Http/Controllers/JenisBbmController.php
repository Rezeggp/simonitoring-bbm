<?php

namespace App\Http\Controllers;

use App\Models\JenisBbm;
use Illuminate\Http\Request;

class JenisBbmController extends Controller
{
    public function index()
    {
        $jenisBbms = JenisBbm::orderBy('nama')->paginate(10);

        return view('jenis-bbm.index', compact('jenisBbms'));
    }

    public function create()
    {
        return view('jenis-bbm.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        JenisBbm::create($data);

        return redirect()->route('jenis-bbm.index')->with('success', 'Jenis BBM baru berhasil ditambahkan.');
    }

    public function edit(JenisBbm $jenisBbm)
    {
        return view('jenis-bbm.edit', compact('jenisBbm'));
    }

    public function update(Request $request, JenisBbm $jenisBbm)
    {
        $data = $this->validateData($request, $jenisBbm->id);
        $jenisBbm->update($data);

        return redirect()->route('jenis-bbm.index')->with('success', 'Jenis BBM berhasil diperbarui.');
    }

    public function destroy(JenisBbm $jenisBbm)
    {
        $jenisBbm->delete();

        return redirect()->route('jenis-bbm.index')->with('success', 'Jenis BBM berhasil dihapus.');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:jenis_bbms,kode,'.($ignoreId ?? 'NULL')],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'in:gasoline,diesel'],
            'harga_per_liter' => ['required', 'integer', 'min:0'],
            'warna_label' => ['required', 'string', 'max:20'],
        ], [
            'kode.required' => 'Kode jenis BBM wajib diisi.',
            'kode.unique' => 'Kode jenis BBM sudah digunakan.',
            'nama.required' => 'Nama jenis BBM wajib diisi.',
            'harga_per_liter.required' => 'Harga per liter wajib diisi.',
            'harga_per_liter.integer' => 'Harga per liter harus berupa angka.',
        ]);
    }
}
