<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HistoryPeminjamanExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    public function collection()
    {
        return Peminjaman::with(['aset', 'user'])->get();
    }

    public function map($row): array
    {
        static $number = 0;
        $number++;

        return [
            'no' => $number,
            'id_Aset' => $row->aset->id,
            'nama_aset' => $row->aset->nama ?? '',
            'nama_peminjam' => $row->user->nama ?? '',
            'status' => $row->status,
            'tanggal_pinjam' => $row->tanggal_pinjam,
            'tanggal_kembali' => $row->tanggal_kembali,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'id_aset',
            'Nama Aset',
            'Nama Peminjam',
            'Status',
            'Tanggal Pinjam',
            'Tanggal Pengembalian',
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
