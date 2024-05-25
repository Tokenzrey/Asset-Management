<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use App\Models\Aset;
use App\Models\Ruang;
use App\Models\Kategori;
use App\Models\Vendor;
// use App\Models\AnggaranDana;
use App\Models\JenisPemeliharaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AsetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (is_numeric($row['tanggal_pembelian'])) {
            $tanggalPembelian = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_pembelian']))->toDateString();
        }else {
            $tanggalPembelian = Carbon::createFromFormat('d/m/Y', $row['tanggal_pembelian'])->toDateString();
        }
        $kategori = Kategori::where('nama', $row['kategori'])->first();
        $vendor = Vendor::where('nama', $row['vendor'])->first();
        $ruang = Ruang::where('nama', $row['ruang'])->first();
        $kode = Aset::generateCode($kategori->kode, Aset::stringToInitial($vendor->nama), Aset::stringToInitial($ruang->nama));
        return new Aset([
            'kode'                  => $kode,
            'nama'                  => $row['nama'],
            'jumlah'                => $row['jumlah'],
            'satuan'                => $row['satuan'],
            'tanggal_pembelian'     => $tanggalPembelian,
            'brand'                 => $row['brand'],
            'kondisi'               => $row['kondisi'],
            'gambar'                => $row['gambar'],
            'nama_penerima'         => $row['nama_penerima'],
            'tempat'                => $row['tempat'],
            'deskripsi'             => $row['deskripsi'],
            'aktif'                 => $row['aktif'],
            'kategori_id'           => $kategori->id,
            'jenis_pemeliharaan_id' => JenisPemeliharaan::where('nama', $row['jenis_pemeliharaan'])->value('id'),
            'ruang_id'              => $ruang->id,
            'vendor_id'             => $vendor->id,
        ]);
    }
}