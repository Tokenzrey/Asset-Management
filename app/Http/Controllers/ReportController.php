<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\User;
use App\Models\Ruang;
use App\Models\Kategori;
use App\Models\Vendor;
// use App\Models\AnggaranDana;
use App\Models\JenisPemeliharaan;
use App\Models\Peminjaman;
use App\Models\JadwalPemeliharaan;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public  function report_aset()
    {
        $aset = Aset::where('aktif', '=', 'y')->get();
        $kategori = Kategori::where('aktif', '=', 'y')->get();
        $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', '=', 'y')->get();
        $ruang = Ruang::where('aktif', '=', 'y')->get();
        $supplier = Vendor::where('aktif', '=', 'y')->get();
        return view('report.aset', [
            'aset'                  => $aset,
            'kategori'              => $kategori,
            'ruang'                 => $ruang,
            'jenis_pemeliharaan'    => $jenis_pemeliharaan,
            'supplier'              => $supplier,
            'kondisi'               => ['Baik', 'Kurang Baik', 'Rusak']
        ]);
    }

    public function report_peminjaman()
    {
        $peminjaman = Peminjaman::where('aktif', 'y')->get();
        $aset = Aset::where('aktif', '=', 'y')->get();
        $kategori = Kategori::where('aktif', '=', 'y')->get();
        $jenis_pemeliharaan = JenisPemeliharaan::where('aktif', '=', 'y')->get();
        $ruang = Ruang::where('aktif', '=', 'y')->get();
        $supplier = Vendor::where('aktif', '=', 'y')->get();
        return view('report.peminjaman', [
            'peminjaman'            => $peminjaman,
            'aset'                  => $aset,
            'kategori'              => $kategori,
            'ruang'                 => $ruang,
            'jenis_pemeliharaan'    => $jenis_pemeliharaan,
            'supplier'              => $supplier,
            'kondisi'               => ['Baik', 'Kurang Baik', 'Rusak']
        ]);
    }

    public function report_history_peminjaman()
        {
            $history_peminjaman = Peminjaman::where('status', '=', 'SELESAI')->get();
            $aset = Aset::where('aktif', '=', 'y')->get();
            $kategori = Kategori::where('aktif', '=', 'y')->get();
            $ruang = Ruang::where('aktif', '=', 'y')->get();
            $user = User::where('aktif', '=', 'y')->get();
            return view('report.history_peminjaman', [
                'history_peminjaman'    => $history_peminjaman,
                'user'                  => $user,
                'kategori'              => $kategori,
                'aset'                  => $aset,
                'ruang'                 => $ruang
            ]);
        }

    public function report_history_pemeliharaan()
        {
            $aset = Aset::where('aktif', '=', 'y')->get();
            $jadwal_pemeliharaan = JadwalPemeliharaan::where('aktif', '=', 'y')->get();
            $today = date('Y-m-d');
            $total_jp = JadwalPemeliharaan::where('status', '=', 'belum')->count();

            return view('report.history_pemeliharaan', [
                'jp' => $jadwal_pemeliharaan,
                'aset' => $aset,
                'status' => ['Belum', 'Proses', 'Selesai'],
                'today' => $today,
                'total_jp' => $total_jp
            ]);
        }
}

