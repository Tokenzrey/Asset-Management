<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::where('aktif', 'y')->get();
        return view('divisi.index', [
            'divisi' => $divisi
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:4'
        ]);

        // Pastikan data tidak duplikat berdasarkan nama divisi
        if (Divisi::where('nama', $request->nama)->exists()) {
            Alert::error('Error', 'Nama Divisi sudah ada');
            return redirect()->route('divisi.index');
        }

        // Membuat data divisi baru
        Divisi::create([
            'nama' => $request->nama,
        ]);

        Alert::success('Success', 'Data Divisi Berhasil ditambahkan');
        return redirect()->route('divisi.index');
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::find($id);
        if (!$divisi) {
            Alert::error('Error', 'Data Divisi Tidak Ditemukan');
            return redirect()->route('divisi.index');
        }

        // Perbarui data divisi
        $data_divisi = [
            'nama' => $request->nama,
        ];

        if ($divisi->update($data_divisi)) {
            Alert::success('Success', 'Data Divisi Berhasil Di Update!');
        } else {
            Alert::error('Error', 'Gagal memperbarui Data Divisi');
        }

        return redirect()->route('divisi.index');
    }

    public function destroy($id)
    {
        $divisi = Divisi::find($id);
        if (!$divisi) {
            Alert::error('Error', 'Data Divisi Tidak Ditemukan');
            return redirect()->route('divisi.index');
        }

        // Update kolom 'aktif' menjadi 't' sebagai tanda penghapusan
        if ($divisi->update(['aktif' => 't'])) {
            Alert::success('Success', 'Data Divisi Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal menghapus Data Divisi');
        }

        return redirect()->route('divisi.index');
    }
}
