<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use Carbon\Carbon;
use App\Models\Aset;

use App\Models\Ruang;
use App\Models\Vendor;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Exports\AsetExport;
// use App\Models\AnggaranDana;
use App\Imports\AsetImport;
use Illuminate\Http\Request;
use App\Models\JenisPemeliharaan;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;


class AsetController extends Controller
{
    public function index()
    {
        // Fetch related models with their active assets
        $aset_in_peminjaman = Peminjaman::where('status', 'DITERIMA')
            ->pluck('aset_id');

        $aset = Aset::where('aktif', 'y')
            ->with('kategori', 'jenis_pemeliharaan', 'ruang', 'vendor')
            ->get();

        $kategori = Kategori::where('aktif', 'y')->get();
        $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', 'y')->get();
        $ruang = Ruang::where('aktif', 'y')->get();
        $vendor = Vendor::where('aktif', 'y')->get();
        $brands = Brand::all();

        $maintenance = Aset::getMaintenanceTime($aset);

        foreach ($aset as $value) {
            $value->DITERIMA = $aset_in_peminjaman->contains($value->id);
        }

        // Assign maintenance time flag to each asset
        foreach ($aset as $value) {
            $value->is_maintenance_time = false;
            foreach ($maintenance as $maintenance_item) {
                if ($value->id == $maintenance_item->id) {
                    $value->is_maintenance_time = $maintenance_item->is_maintenance_time;
                }
            }
        }

        return view('aset.index', [
            'aset' => $aset,
            'kategori' => $kategori,
            'ruang' => $ruang,
            'jenis_pemeliharaan' => $jenis_pemeliharaan,
            'vendor' => $vendor,
            'brands' => $brands,
            'kondisi' => ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        ]);
    }

    public function store(Request $request)
    {
        $gambar = null;
        if ($request->file('gambar')) {
            $gambar_extension = $request->file('gambar')->extension();
            if (in_array($gambar_extension, array('jpg', 'jpeg', 'png')) == false) {
                Alert::error('Error', 'Type gambar yang diijinkan jpg,jpeg,png!');
                return redirect()->route('user.index');
            }
            $gambar = $request->file('gambar')->store('public/gambar_user');
            $gambar = str_replace('public/', '', $gambar);
        } else {
            Alert::error('Error', 'Gambar wajib diunggah!');
            return redirect()->route('aset.index');
        }
        $jumlah = 1;
        $satuan = 'unit';

        try {
            $vendor = Vendor::where('id', $request->vendor_id)->firstOrFail();
            $kategori = Kategori::where('id', $request->kategori_id)->firstOrFail();
            $ruang = Ruang::where('id', $request->ruang_id)->firstOrFail();
        } catch (\Exception $e) {
            Alert::error('Error', 'Data Vendor, Kategori, atau Ruang Tidak Ditemukan');
            return redirect()->route('aset.index');
        }

        $kode = Aset::generateCode($kategori->kode, Aset::stringToInitial($vendor->nama), Aset::stringToInitial($ruang->nama));
        $aset = Aset::where('kode', $kode)->first();
        if ($aset) {
            Alert::error('Warning', 'Kode sudah terpakai oleh aset' . $aset->nama . '| Silahkan Ganti Kode Anda');
            return redirect()->route('aset.index');
        }
        $request->qrcode == $kode;
        Aset::create([
            'kode' => $kode,
            'nama' => $request->nama,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'brand_id' => $request->brand_id,
            'kondisi' => $request->kondisi,
            'gambar' => ($gambar) ? $gambar : null,
            'nama_penerima' => $request->nama_penerima,
            'tempat' => $request->tempat,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
            'jenis_pemeliharaan_id' => $request->jenis_pemeliharaan_id,
            'ruang_id' => $request->ruang_id,
            'vendor_id' => $request->vendor_id
        ]);
        Alert::success('Success', 'Aset Berhasil Ditambahkan');
        return redirect()->route('aset.index');
    }

    public function show($id)
    {
        $aset = Aset::find($id);
        $vendor = Vendor::where('aktif', '=', 'y')->get();
        $kategori = Kategori::where('aktif', '=', 'y')->get();
        $ruang = Ruang::where('aktif', '=', 'y')->get();
        $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', '=', 'y')->get();
        $brands = Brand::all();

        return view('aset.show', [
            'aset' => $aset,
            'vendor' => $vendor,
            'kategori' => $kategori,
            'ruang' => $ruang,
            'jenis_pemeliharaan' => $jenis_pemeliharaan,
            'brands' => $brands,
            'kondisi' => ['Baik', 'Rusak Ringan', 'Rusak Berat']
        ]);
    }

    public function update(Request $request, $id)
    {
        $aset = Aset::find($id);
        if (!$aset) {
            Alert::error('Error', 'Aset Tidak Ditemukan');
            return redirect()->route('aset.index');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'brand_id' => 'required',
            'kondisi' => 'required|string',
            'tempat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|integer',
            'jenis_pemeliharaan_id' => 'required|integer',
            'ruang_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            Alert::error('Validasi Gagal', $errorMessage);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data_aset = [
            'nama' => $request->nama,
            'jumlah' => 1,
            'satuan' => 'unit',
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'brand_id' => $request->brand_id,
            'kondisi' => $request->kondisi,
            'tempat' => $request->tempat,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
            'jenis_pemeliharaan_id' => $request->jenis_pemeliharaan_id,
            'ruang_id' => $request->ruang_id,
            'vendor_id' => $request->vendor_id,
        ];

        // Hanya update gambar jika ada file yang diunggah
        if ($request->hasFile('gambar')) {
            $gambar_extension = $request->file('gambar')->extension();
            if (!in_array($gambar_extension, ['jpg', 'jpeg', 'png'])) {
                Alert::error('Error', 'Tipe gambar yang diijinkan: jpg, jpeg, png');
                return redirect()->route('user.index');
            }
            $gambar = $request->file('gambar')->store('public/gambar_aset');
            $gambar = str_replace('public/', '', $gambar);

            $data_aset['gambar'] = $gambar;
        }

        $aset->update($data_aset);

        Alert::success('Success', 'Aset Berhasil Di Update!');
        return redirect()->route('aset.show', $id);
    }

    public function destroy($id)
    {
        $aset = Aset::find($id);

        if (!$aset) {
            Alert::error('Error', 'Data Aset Tidak Ditemukan');
            return redirect()->route('aset.index');
        }

        // Cek relasi dengan peminjaman
        $peminjamanAktif = Peminjaman::where('aset_id', $id)
            ->where('status', '!=', 'SELESAI')
            ->where('status', '!=', 'DITOLAK')
            ->where('aktif', 'y') // Hanya cek peminjaman aktif
            ->exists();

        // Cek relasi dengan jadwal pemeliharaan
        $pemeliharaanAktif = JadwalPemeliharaan::where('aset_id', $id)
            ->where('status', '!=', 'SELESAI')
            ->where('aktif', 'y') // Hanya cek pemeliharaan aktif
            ->exists();

        // Jika ada relasi yang belum selesai dan aktif, cegah penghapusan
        if ($peminjamanAktif || $pemeliharaanAktif) {
            Alert::error('Error', 'Data Aset Tidak Bisa Dihapus Karena Masih Memiliki Relasi yang Belum Selesai atau Aktif');
            return redirect()->route('aset.index');
        }

        // Soft delete aset (ubah status 'aktif' menjadi 't')
        $isUpdated = $aset->update(['aktif' => 't']);

        if ($isUpdated) {
            Alert::success('Success', 'Data Aset Berhasil Dihapus');
        } else {
            Alert::error('Error', 'Gagal Menghapus Data Aset');
        }

        return redirect()->route('aset.index');
    }

    public function restore($id)
    {
        $aset = Aset::find($id);
        if (!$aset) {
            Alert::error('Error', 'Data Aset Tidak Ditemukan');
            return redirect()->route('aset.index');
        }
        $aset->where('id', $id)->update(['aktif' => 'y']);
        Alert::success('Success', 'Data Aset Berhasil Dipulihkan');
        return redirect()->route('aset.index');
    }

    public function qrcode(Request $request)
    {
        $id = $request->id;
        $qrcode = Aset::where('kode', $id)->firstOrFail();
        return view('aset.qrcode', [
            'qrcode' => $qrcode
        ]);
    }

    public function scan_qrcode(Request $request)
    {
        if ($request->keyword) {
            $aset = Aset::search($request->keyword)->get();
        } else {
            $aset = Aset::where('aktif', '=', 'y')->get();
        }
        return view('aset.scan_qrcode', [
            'aset' => $aset
        ]);
    }

    public function cetakqrcode(Request $request)
    {
        $id = $request->id;
        $qrcode = Aset::where('kode', $id)->firstOrFail();
        return view('aset.cetakqrcode', [
            'qrcode' => $qrcode
        ]);
    }

    // public function history()
    // {
    //     $aset = Aset::where('aktif', '=', 't')->get();
    //     $kategori = Kategori::where('aktif', '=', 'y')->get();
    //     $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', '=', 'y')->get();
    //     $ruang = Ruang::where('aktif', '=', 'y')->get();
    //     $supplier = Vendor::where('aktif', '=', 'y')->get();
    //     return view('aset.history', [
    //         'aset'                  => $aset,
    //         'kategori'              => $kategori,
    //         'ruang'                 => $ruang,
    //         'jenis_pemeliharaan'    => $jenis_pemeliharaan,
    //         'supplier'              => $supplier,
    //         'kondisi'               => ['Baik', 'Rusak Ringan', 'Rusak Berat']
    //     ]);
    // }

    // public function destroy_history($id)
    // {
    //     $aset = Aset::find($id);
    //     if (!$aset) {
    //         Alert::error('Error', 'Data Divisi Tidak Ditemukan');
    //         return redirect()->route('aset.index');
    //     }
    //     $aset->where('id', $id)->delete();
    //     Alert::success('Success', 'Data dari history Aset Berhasil Dihapus | Data tidak bisa Dikembalikan');
    //     return redirect()->route('aset.index');
    // }

    public function aset_export()
    {
        return Excel::download(new AsetExport, 'data-aset.xlsx');
    }

    public function aset_import(Request $request)
    {
        $file = $request->file('file');

        // Periksa ekstensi file
        $allowedExtensions = ['xlsx'];
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedExtensions)) {
            Alert::error('Error', 'File yang diunggah harus memiliki ekstensi XLSX.');
            return redirect()->route('aset.index');
        }

        $namaFile = $file->getClientOriginalName();
        $file->move('DataAset', $namaFile);

        try {
            // Import data dari file Excel
            Excel::import(new AsetImport, public_path('/DataAset/' . $namaFile));
            Alert::success('Success', 'Data Berhasil Di Import');
        } catch (\Exception $e) {
            // Tangani kesalahan saat mengimpor data Excel
            Alert::error('Error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
            return redirect()->route('aset.index');
        }
        return redirect()->route('aset.index');
    }
}
