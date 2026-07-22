<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    public function index(Request $request)
    {
        $depots = Depot::withCount('stoks')
            ->when($request->search, fn ($q) => $q->where('nama_depot', 'like', '%'.$request->search.'%')
                ->orWhere('kode_depot', 'like', '%'.$request->search.'%'))
            ->orderBy('nama_depot')
            ->paginate(10)
            ->withQueryString();

        return view('depots.index', compact('depots'));
    }

    public function create()
    {
        return view('depots.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Depot::create($data);

        return redirect()->route('depots.index')->with('success', 'Terminal BBM (depot) baru berhasil ditambahkan.');
    }

    public function edit(Depot $depot)
    {
        return view('depots.edit', compact('depot'));
    }

    public function update(Request $request, Depot $depot)
    {
        $data = $this->validateData($request, $depot->id);
        $depot->update($data);

        return redirect()->route('depots.index')->with('success', 'Data depot berhasil diperbarui.');
    }

    public function destroy(Depot $depot)
    {
        $depot->delete();

        return redirect()->route('depots.index')->with('success', 'Data depot berhasil dihapus.');
    }

    private function validateData(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_depot' => ['required', 'string', 'max:20', 'unique:depots,kode_depot,'.($ignoreId ?? 'NULL')],
            'nama_depot' => ['required', 'string', 'max:150'],
            'lokasi' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'kode_depot.required' => 'Kode depot wajib diisi.',
            'kode_depot.unique' => 'Kode depot sudah digunakan.',
            'nama_depot.required' => 'Nama depot wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
        ]);
    }
}
