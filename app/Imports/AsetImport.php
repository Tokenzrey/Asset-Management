<?php

namespace App\Imports;

use Illuminate\Support\Carbon;
use App\Models\Aset;
use App\Models\Brand;
use App\Models\Ruang;
use App\Models\Kategori;
use App\Models\Vendor;
use App\Models\JenisPemeliharaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AsetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Konversi tanggal pembelian
        if (is_numeric($row['tanggal_pembelian'])) {
            $tanggalPembelian = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_pembelian']))->toDateString();
        } else {
            $tanggalPembelian = Carbon::createFromFormat('d/m/Y', $row['tanggal_pembelian'])->toDateString();
        }

        // Temukan atau buat data kategori dengan logika kode dari KategoriController
        $kategori = Kategori::firstOrCreate(
            ['nama' => $row['kategori']],
            ['kode' => $this->generateKategoriKode($row['kategori'])]
        );

        // Temukan atau buat data brand
        $brand = Brand::firstOrCreate(
            ['nama' => $row['brand']]
        );

        // Temukan atau buat data vendor
        $vendor = Vendor::firstOrCreate(
            ['nama' => $row['vendor']]
        );

        // Temukan atau buat data ruang
        $ruang = Ruang::firstOrCreate(
            ['nama' => $row['ruang']]
        );

        // Temukan atau buat data jenis pemeliharaan
        $jenisPemeliharaan = JenisPemeliharaan::firstOrCreate(
            ['nama' => $row['jenis_pemeliharaan']]
        );

        // Generate kode aset
        $kode = Aset::generateCode($kategori->kode, Aset::stringToInitial($vendor->nama), Aset::stringToInitial($ruang->nama));

        // Kembalikan model Aset baru
        return new Aset([
            'kode' => $kode,
            'nama' => $row['nama'],
            'jumlah' => $row['jumlah'],
            'satuan' => $row['satuan'],
            'tanggal_pembelian' => $tanggalPembelian,
            'brand_id' => $brand->id,
            'kondisi' => $row['kondisi'],
            'gambar' => $row['gambar'],
            'nama_penerima' => $row['nama_penerima'],
            'tempat' => $row['tempat'],
            'deskripsi' => $row['deskripsi'],
            'aktif' => $row['aktif'],
            'kategori_id' => $kategori->id,
            'jenis_pemeliharaan_id' => $jenisPemeliharaan->id,
            'ruang_id' => $ruang->id,
            'vendor_id' => $vendor->id,
        ]);
    }

    /**
     * Generate a unique category code based on the name.
     *
     * @param string $namaKategori
     * @return string
     */
    private function generateKategoriKode($namaKategori)
    {
        // Generate 2-character uppercase code from the name
        $words = explode(' ', $namaKategori);
        $code = count($words) > 1
            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
            : strtoupper(substr($namaKategori, 0, 2));

        // Ensure the generated code is unique in the Kategori table
        $codeUnique = Kategori::where('kode', '=', $code)->exists();
        if ($codeUnique) {
            $code = strtoupper(substr($namaKategori, 0, 1) . substr($namaKategori, 2, 1));
        }

        return $code;
    }
}
