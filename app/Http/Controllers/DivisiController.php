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
            'nama' => 'required'
        ]);

        // Check for existing active divisi with the same name
        $existingActiveDivisi = Divisi::where('nama', $request->nama)
            ->where('aktif', 'y')
            ->first();

        if ($existingActiveDivisi) {
            Alert::error('Error', 'Nama Divisi sudah ada');
            return redirect()->route('divisi.index');
        }

        // // Check for existing inactive divisi with the same name
        // $inactiveDivisi = Divisi::where('nama', $request->nama)
        //     ->where('aktif', 't')
        //     ->orderByDesc('duplicateID')
        //     ->first();

        // // Determine the new duplicateID
        // $newDuplicateID = $request->nama;
        // if ($inactiveDivisi) {
        //     // Extract the number from the existing duplicateID
        //     preg_match('/(\d+)$/', $inactiveDivisi->duplicateID, $matches);
        //     $numberOfDuplicate = $matches ? intval($matches[1]) + 1 : 1;
        //     $newDuplicateID = $request->nama . $numberOfDuplicate;
        // }

        // Create new divisi
        Divisi::create([
            'nama' => $request->nama,
            'duplicateID' => $request->nama
        ]);

        Alert::success('Success', 'Data Divisi Berhasil ditambahkan');
        return redirect()->route('divisi.index');
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'nama' => 'required'
    //     ]);

    //     // Pastikan data tidak duplikat berdasarkan nama divisi
    //     if (Divisi::where('nama', $request->nama)->exists()) {
    //         Alert::error('Error', 'Nama Divisi sudah ada');
    //         return redirect()->route('divisi.index');
    //     }

    //     // Membuat data divisi baru
    //     Divisi::create([
    //         'nama' => $request->nama,
    //     ]);

    //     Alert::success('Success', 'Data Divisi Berhasil ditambahkan');
    //     return redirect()->route('divisi.index');
    // }

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

    // public function destroy($id)
    // {
    //     $divisi = Divisi::find($id);
    //     if (!$divisi) {
    //         Alert::error('Error', 'Data Divisi Tidak Ditemukan');
    //         return redirect()->route('divisi.index');
    //     }

    //     $inactiveDivisi = Divisi::where('nama', $divisi->nama)
    //         ->where('aktif', 't')
    //         ->orderByDesc('duplicateID')
    //         ->first();

    //     // Determine the new duplicateID
    //     $newDuplicateID = $divisi->nama;
    //     if ($inactiveDivisi) {
    //         // Extract the number from the existing duplicateID
    //         preg_match('/(\d+)$/', $inactiveDivisi->duplicateID, $matches);
    //         $numberOfDuplicate = $matches ? intval($matches[1]) + 1 : 1;
    //         $newDuplicateID = $divisi->nama . $numberOfDuplicate;
    //     }

    //     // Update kolom 'aktif' menjadi 't' sebagai tanda penghapusan
    //     if ($divisi->update(['aktif' => 't']) && $divisi->update(['duplicateID' => $newDuplicateID])) {
    //         Alert::success('Success', 'Data Divisi Berhasil Dihapus');
    //     } else {
    //         Alert::error('Error', 'Gagal menghapus Data Divisi');
    //     }

    //     return redirect()->route('divisi.index');
    // }
    public function destroy($id)
    {
        $divisi = Divisi::find($id);
        if (!$divisi) {
            Alert::error('Error', 'Data Divisi Tidak Ditemukan');
            return redirect()->route('divisi.index');
        }

        $inactiveDivisi = Divisi::where('nama', $divisi->nama)
            ->where('aktif', 't')
            ->orderByDesc('duplicateID')
            ->first();

        // Determine the new duplicateID
        $newDuplicateID = $divisi->nama;
        if ($inactiveDivisi) {
            // Extract the number from the existing duplicateID
            preg_match('/(\d+)$/', $inactiveDivisi->duplicateID, $matches);
            $numberOfDuplicate = $matches ? intval($matches[1]) + 1 : 1;
            $newDuplicateID = $divisi->nama . $numberOfDuplicate;
        } else {
            $numberOfDuplicate = 0;
            $newDuplicateID = $divisi->nama . $numberOfDuplicate;
        }

        // Update kolom 'aktif' dan 'duplicateID'
        $divisi->aktif = 't';
        $divisi->duplicateID = $newDuplicateID;

        if ($divisi->save()) {
            Alert::success('Success', 'Data Divisi Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal menghapus Data Divisi');
        }

        return redirect()->route('divisi.index');
    }
}
