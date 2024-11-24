<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{

    public function index()
    {
        $vendor = Vendor::where('aktif', '=', 'y')->get();
        return view('supplier.index', [
            'vendor' => $vendor
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required'
         ]);
         $exists = Vendor::where('nama', $request->nama)->where('aktif', 'y')->exists();
         if ($exists) {
            // Trigger error alert if duplicate name is found
            Alert::error('Error', 'Nama Vendor sudah ada, silakan gunakan nama lain');
            return redirect()->back()->withInput();
        }    
         Vendor::where(['id' => $request->id])->first();
         Vendor::create([
             'nama'         => $request->nama,
             'alamat'       => $request->alamat,
             'deskripsi'    => $request->deskripsi
         ]);
         Alert::success('Success', 'Data Vendor berhasil ditambahkan');
         return redirect()->route('vendor.index');
    }

    public function show($id)
    {
        $vendor = Vendor::all()->find($id);
        return view('supplier.show', [
            'vendor' => $vendor
        ]);
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        if(!$vendor) {
            Alert::error('Error', 'Data Vendor tidak ditemukan');
            return redirect()->route('vendor.index');
        }

        $data_vendor = [
            'nama'      => $request->nama,
            'alamat'    => $request->alamat,
            'deskripsi' => $request->deskripsi
        ];

        $vendor->update($data_vendor);
        Alert::success('Success', 'Data Vendor Berhasil Di Update');
        return redirect()->route('vendor.index');
    }

    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            Alert::error('Error', 'Vendor Tidak Ditemukan');
            return redirect()->route('vendor.index');
        }

        $isUpdated = $vendor->update(['aktif' => 't']);

        if ($isUpdated) {
            Alert::success('Success', 'Data Vendor Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal Menghapus Data Vendor');
        }

        return redirect()->route('vendor.index');
    }
}
