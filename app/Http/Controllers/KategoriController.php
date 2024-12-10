<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::where('aktif', '=', 'y')->get();
        return view('kategori.index', [
            'kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
        ]);

        $exists = Kategori::where('nama', $request->nama)->where('aktif', 'y')->exists();

        if ($exists) {
            // Trigger error alert if duplicate name is found
            Alert::error('Error', 'Nama Kategori sudah ada, silakan gunakan nama lain');
            return redirect()->back()->withInput();
        }
        // Generate 2-character uppercase code from the name
        $words = explode(' ', $request->nama);
        $code = count($words) > 1 ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)) : strtoupper(substr($request->nama, 0, 2));

        // Ensure code is unique
        $codeUnique = Kategori::where('kode', '=', $code)->first();
        if ($codeUnique) {
            $code = strtoupper(substr($request->nama, 0, 1) . substr($request->nama, 2, 1));
        }

        // Create new Kategori record
        Kategori::create([
            'nama' => $request->nama,
            'kode' => $code,
            'masa_manfaat' => $request->masa_manfaat,
        ]);

        Alert::success('Success', 'Data kategori Berhasil Ditambahkan');
        return redirect()->route('kategori.index');
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.show', [
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            Alert::error('Error', 'Kategori Tidak Ditemukan');
            return redirect()->route('kategori.index');
        }
        $exists = Kategori::where('nama', $request->nama)->where('id', '!=', $id)->where('aktif', 'y')->exists();

        if ($exists) {
            // Trigger error alert if duplicate name is found
            Alert::error('Error', 'Nama Kategori sudah ada, silakan gunakan nama lain');
            return redirect()->back()->withInput();
            }
        $data_kategori = [
            'nama' => $request->nama,
            'masa_manfaat' => $request->masa_manfaat
        ];

        $kategori->update($data_kategori);

        Alert::success('Success', 'Kategori Berhasil Di Update!');
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
    
            // Attempt to delete the kategori
            $kategori->delete();
    
            Alert::success('Success', 'Data Kategori Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for foreign key constraint violation
            if ($e->getCode() == 23000) {
                Alert::error('Error', 'Data Kategori Tidak Bisa Dihapus Karena Masih Berelasi dengan Data Lain');
            } else {
                Alert::error('Error', 'Terjadi Kesalahan saat Menghapus Data Kategori');
            }
        }
    
        return redirect()->route('kategori.index');
    }
}
