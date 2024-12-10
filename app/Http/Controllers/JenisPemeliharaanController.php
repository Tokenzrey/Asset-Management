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
            'nama' => 'required'
        ]);
        // Check if 'nama' already exists
        $exists = JenisPemeliharaan::where('nama', $request->nama)->where('aktif', 'y')->exists();

        if ($exists) {
            // Trigger error alert if duplicate name is found
            Alert::error('Error', 'Nama Jenis Pemeliharaan sudah ada, silakan gunakan nama lain.');
            return redirect()->back()->withInput();
        }
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
            'nama' => 'required'
        ]);
        // Check if another record with the same 'nama' already exists
        $exists = JenisPemeliharaan::where('nama', $request->nama)
        ->where('id', '!=', $id) // Exclude the current record
        ->where('aktif', 'y')
        ->exists();

        if ($exists) {
        // Trigger error alert if duplicate name is found
        Alert::error('Error', 'Nama Jenis Pemeliharaan sudah ada, silakan gunakan nama lain.');
        return redirect()->back()->withInput();
        }
        // Update data langsung tanpa where array
        $jenis_pemeliharaan->update([
            'nama' => $request->nama,
        ]);

        Alert::success('Success', 'Jenis Pemeliharaan Berhasil Di Update');
        return redirect()->route('jenis_pemeliharaan.index');
    }

    public function destroy($id)
    {
        try {
            $jenis_pemeliharaan = JenisPemeliharaan::findOrFail($id);
    
            // Attempt to delete the jenis_pemeliharaan
            $jenis_pemeliharaan->delete();
    
            Alert::success('Success', 'Data Jenis Pemeliharaan Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for foreign key constraint violation
            if ($e->getCode() == 23000) {
                Alert::error('Error', 'Data Jenis Pemeliharaan Tidak Bisa Dihapus Karena Masih Berelasi dengan Data Lain');
            } else {
                Alert::error('Error', 'Terjadi Kesalahan saat Menghapus Data Jenis Pemeliharaan');
            }
        }
    
        return redirect()->route('jenis_pemeliharaan.index');
    }
}
