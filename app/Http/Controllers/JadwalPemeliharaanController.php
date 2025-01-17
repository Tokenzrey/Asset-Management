<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Aset;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalPemeliharaanController extends Controller
{
    public function index()
    {
        // Only include maintenance schedules for active assets
        $aset = Aset::where('aktif', '=', 'y')->get();
        $jadwal_pemeliharaan = JadwalPemeliharaan::whereHas('aset', function ($query) {
            $query->where('aktif', '=', 'y');
        })->where('aktif', '=', 'y')->get();

        $today = date('Y-m-d');
        $total_jp = JadwalPemeliharaan::whereHas('aset', function ($query) {
            $query->where('aktif', '=', 'y');
        })->where('status', '=', 'belum')->count();

        return view('jadwal_pemeliharaan.index', [
            'jp' => $jadwal_pemeliharaan,
            'aset' => $aset,
            'status' => ['Belum', 'Proses', 'Selesai'],
            'today' => $today,
            'total_jp' => $total_jp,
        ]);
    }

    public function store(Request $request)
    {
        // $gambar = null;
        // if ($request->file('gambar')) {
        //     $gambar = $request->file('gambar')->store('public/gambar_aset');
        //     $gambar = str_replace('public/', '', $gambar);
        // }else{
        //     Alert::error('Error', 'Gambar wajib diunggah!');
        //     return redirect()->route('jadwal_pemeliharaan.index');
        // }

        JadwalPemeliharaan::create([
            'aset_id' => $request->aset_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status
        ]);
        Alert::success('Success', 'Jadwal Pemeliharaan Berhasil Ditambahkan');
        return redirect()->route('jadwal_pemeliharaan.index');
    }

    public function update(Request $request, $id)
    {
        $jadwal_pemeliharaan = JadwalPemeliharaan::find($id);
        if (!$jadwal_pemeliharaan) {
            Alert::error('Error', 'Jadwal aset Tidak Ditemukan');
            return redirect()->route('jadwal_pemeliharaan.index');
        }

        $data_jadwal_pemeliharaan = [
            // 'aset_id' => $request->aset_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status
        ];

        // Perbaiki penggunaan where() untuk update
        $jadwal_pemeliharaan->where('id', $id)->update($data_jadwal_pemeliharaan);
        Alert::success('Success', 'Jadwal Pemeliharaan Berhasil Di Update!');
        return redirect()->route('jadwal_pemeliharaan.index');
    }

    public function destroy($id)
    {
        $jadwal_pemeliharaan = JadwalPemeliharaan::find($id);

        if (!$jadwal_pemeliharaan) {
            return back()->withInput()->with('error', 'Jadwal Pemeliharaan tidak ditemukan!');
        }

        // Langsung update kolom 'aktif' pada instance yang ditemukan
        if ($jadwal_pemeliharaan->update(['aktif' => 't'])) {
            Alert::success('Success', 'Data Berhasil Dihapus');
        } else {
            return back()->with('error', 'Gagal menghapus Jadwal Pemeliharaan.');
        }

        return redirect()->route('jadwal_pemeliharaan.index');
    }
}
