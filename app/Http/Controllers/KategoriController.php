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
            'nama' => 'required|min:4'
        ]);
        // from name make 2 character uppercase code from word if word more than 2 word make 2 character uppercase code from first word
        $words = explode(' ', $request->nama);
        $code = '';
        if (count($words) > 1) {
            $code = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $code = strtoupper(substr($request->nama, 0, 2));
        }
        $codeUnique = Kategori::where('kode', '=', $code)->first();
        if ($codeUnique) {
              $code = strtoupper(substr($request->nama, 0, 1) . substr($request->nama, 2, 1));
        }
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
            'batas_masa_manfaat_tahun' => $request->batas_masa_manfaat_tahun
        ];

        $kategori->where(['id' => $id])->update($data_kategori);
        Alert::success('Success', 'Kategori Berhasil Di Update!');
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if(!$kategori) {
            Alert::error('Error', 'Kategori Tidak Ditemukan');
            return redirect()->route('kategori.index');
        }
        $kategori->where(['id' => $id])->update(['aktif' => 't']);
        Alert::success('Success', 'Data Berhasil Dihapus');
        return redirect()->route('kategori.index');
    }
}
