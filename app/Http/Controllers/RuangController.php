<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RuangController extends Controller
{
    public function index()
    {
        $ruang = Ruang::where('aktif', 'y')->get();
        return view('ruang.index', [
            'ruang' => $ruang
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:4'
        ]);

        // Tidak perlu mencari dengan where terlebih dahulu karena hanya akan create data baru
        Ruang::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ]);

        Alert::success('Success', 'Data Lokasi berhasil ditambahkan');
        return redirect()->route('ruang.index');
    }

    public function show($id)
    {
        $ruang = Ruang::find($id);
        return view('ruang.show', [
            'ruang' => $ruang
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruang = Ruang::find($id);
        if (!$ruang) {
            Alert::error('Error', 'Data Lokasi tidak ditemukan');
            return redirect()->route('ruang.index');
        }

        $data_ruang = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ];

        $ruang->update($data_ruang);

        Alert::success('Success', 'Data Lokasi Berhasil Di Update');
        return redirect()->route('ruang.index');
    }

    public function destroy($id)
    {
        $ruang = Ruang::find($id);
        if (!$ruang) {
            Alert::error('Error', 'Lokasi Tidak Ditemukan');
            return redirect()->route('ruang.index');
        }

        // Update langsung tanpa where karena $ruang sudah berupa instance dari Ruang
        $ruang->update(['aktif' => 't']);

        Alert::success('Success', 'Data Lokasi Berhasil dihapus');
        return redirect()->route('ruang.index');
    }
}
