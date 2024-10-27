<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\Ruang;
use App\Models\Kategori;
// use App\Models\AnggaranDana;
use App\Models\JenisPemeliharaan;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsetExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;
    public function collection()
    {
        return Aset::where('aktif', '=', 'y')->get();
    }

    public function map($row): array
    {
        static $number = 0;
        $number++;

        return [
            'no'                    => $number,
            'kode'                  => $row->kode,
            'nama'                  => $row->nama,
            'jumlah'                => $row->jumlah,
            'satuan'                => $row->satuan,
            'tanggal_pembelian'     => Carbon::parse($row->tanggal_pembelian)->format('d/m/Y'),
            'brand_id'              => $row->brand->name,
            'kondisi'               => $row->kondisi,
            'gambar'                => $row->gambar,
            'nama_penerima'         => $row->nama_penerima,
            'tempat'                => $row->tempat,
            'deskripsi'             => $row->deskripsi,
            'aktif'                 => $row->aktif,
            'kategori_id'           => $row->kategori_id ? Kategori::find($row->kategori_id)->nama : '',
            'jenis_pemeliharaan_id' => $row->jenis_pemeliharaan_id ? JenisPemeliharaan::find($row->jenis_pemeliharaan_id)->nama : '',
            'ruang_id'              => $row->ruang_id ? Ruang::find($row->ruang_id)->nama : '',
            'vendor_id'           => $row->vendor_id ? Vendor::find($row->vendor_id)->nama : '',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Nama',
            'Jumlah',
            'Satuan',
            'Tanggal Pembelian',
            'Brand',
            'Kondisi',
            'Gambar',
            'Nama Penerima',
            'Tempat',
            'Deskripsi',
            'Aktif',
            'Kategori',
            'Jenis Pemeliharaan',
            'Ruang',
            'Vendor',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00FF00']],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            '2:' . $sheet->getHighestRow() => [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
