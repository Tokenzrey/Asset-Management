<?php

namespace App\Http\Controllers;

use App\Models\JenisPemeliharaan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JenisPemeliharaanController extends Controller
{
    public function index()
    {
        $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', 'y')->get();
        return view('jenis_pemeliharaan.index', compact('jenis_pemeliharaan'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:4'
        ]);

        // Hapus penggunaan where di sini, cukup langsung create data baru
        JenisPemeliharaan::create([
            'nama' => $request->nama,
            'aktif' => 'y'  // tambahkan aktif agar default 'y' pada create
        ]);

        Alert::success('Success', 'Data Jenis Pemeliharaan Berhasil Ditambahkan');
        return redirect()->route('jenis_pemeliharaan.index');
    }

    public function show($id)
    {
        $jenis_pemeliharaan = JenisPemeliharaan::findOrFail($id);
        return view('jenis_pemeliharaan.show', compact('jenis_pemeliharaan'));
    }

    public function update(Request $request, $id)
    {
        $jenis_pemeliharaan = JenisPemeliharaan::find($id);
        if (!$jenis_pemeliharaan) {
            Alert::error('Error', 'Jenis Pemeliharaan Tidak Ditemukan');
            return redirect()->route('jenis_pemeliharaan.index');
        }

        $this->validate($request, [
            'nama' => 'required|min:4'
        ]);

        // Update data langsung tanpa where array
        $jenis_pemeliharaan->update([
            'nama' => $request->nama,
        ]);

        Alert::success('Success', 'Jenis Pemeliharaan Berhasil Di Update');
        return redirect()->route('jenis_pemeliharaan.index');
    }

    public function destroy($id)
    {
        $jenis_pemeliharaan = JenisPemeliharaan::find($id);

        if (!$jenis_pemeliharaan) {
            Alert::error('Error', 'Jenis Pemeliharaan Tidak Ditemukan');
            return redirect()->route('jenis_pemeliharaan.index');
        }

        // Update kolom 'aktif' menjadi 't' untuk soft delete
        if ($jenis_pemeliharaan->update(['aktif' => 't'])) {
            Alert::success('Success', 'Data Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal Menghapus Data');
        }

        return redirect()->route('jenis_pemeliharaan.index');
    }
}
