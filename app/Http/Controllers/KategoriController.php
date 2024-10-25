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
        $kategori = Kategori::find($id);

        if (!$kategori) {
            Alert::error('Error', 'Kategori Tidak Ditemukan');
            return redirect()->route('kategori.index');
        }

        // Cek apakah update berhasil
        if ($kategori->update(['aktif' => 't'])) {
            Alert::success('Success', 'Data Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal Menghapus Data');
        }

        return redirect()->route('kategori.index');
    }
}
