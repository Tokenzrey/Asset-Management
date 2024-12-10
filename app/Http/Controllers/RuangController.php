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
            'nama' => 'required'
        ]);
        
        $exists = Ruang::where('nama', $request->nama)->where('aktif', 'y')->exists();

        if ($exists) {
            Alert::error('Error', 'Nama Lokasi sudah ada, silakan gunakan nama lain');
            return redirect()->back()->withInput();
        }

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

        $exists = Ruang::where('nama', $request->nama)->where('id', '!=', $id)->where('aktif', 'y')->exists();

        if ($exists) {
            // Trigger error alert if duplicate name is found
            Alert::error('Error', 'Nama Lokasi sudah ada, silakan gunakan nama lain');
            return redirect()->back()->withInput();
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
        try {
            $ruang = Ruang::findOrFail($id);
    
            // Attempt to delete the ruang
            $ruang->delete();
    
            Alert::success('Success', 'Data Lokasi Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for foreign key constraint violation
            if ($e->getCode() == 23000) {
                Alert::error('Error', 'Data Lokasi Tidak Bisa Dihapus Karena Masih Berelasi dengan Data Lain');
            } else {
                Alert::error('Error', 'Terjadi Kesalahan saat Menghapus Data Lokasi');
            }
        }
    
        return redirect()->route('ruang.index');
    }
}
