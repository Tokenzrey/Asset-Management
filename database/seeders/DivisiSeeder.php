<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Divisi::truncate();
        //1
        Divisi::create([
            'nama'      => 'Kepala Sekolah',
            'duplicateID' => 'Kepala Sekolah'
        ]);

        //2
        Divisi::create([
            'nama'      => 'Koordinator Tata Usaha',
            'duplicateID' => 'Koordinator Tata Usaha'
        ]);

        //3
        Divisi::create([
            'nama'      => 'Administrasi Kepegawaian',
            'duplicateID' => 'Administrasi Kepegawaian'
        ]);

        //4
        Divisi::create([
            'nama'      => 'Administrasi Keuangan',
            'duplicateID' => 'Administrasi Keuangan'
        ]);

        //5
        Divisi::create([
            'nama'      => 'Administrasi Sarana dan Prasarana',
            'duplicateID' => 'Administrasi Sarana dan Prasarana'
        ]);

        //6
        Divisi::create([
            'nama'      => 'Administrasi Hubungan Masyarakat',
            'duplicateID' => 'Administrasi Hubungan Masyarakat'
        ]);

        //7
        Divisi::create([
            'nama'      => 'Administrasi Umum dan Kearsipan',
            'duplicateID' => 'Administrasi Umum dan Kearsipan'
        ]);

        //8
        Divisi::create([
            'nama'      => 'Administrasi Kesiswaan',
            'duplicateID' => 'Administrasi Kesiswaan'
        ]);

        //9
        Divisi::create([
            'nama'      => 'Administrasi Kurikulum',
            'duplicateID' => 'Administrasi Kurikulum'
        ]);

        //10
        Divisi::create([
            'nama'      => 'Administrasi Perpustakaan',
            'duplicateID' => 'Administrasi Perpustakaan'
        ]);

        //11
        Divisi::create([
            'nama'      => 'Administrasi Operator Dapodik',
            'duplicateID' => 'Administrasi Operator Dapodik'
        ]);

        //12
        Divisi::create([
            'nama'      => 'Administrasi Unit Produksi dan Jasa',
            'duplicateID' => 'Administrasi Unit Produksi dan Jasa'
        ]);

        //13
        Divisi::create([
            'nama'      => 'Toolman',
            'duplicateID' => 'Toolman'
        ]);

        //14
        Divisi::create([
            'nama'      => 'Petugas Kebersihan',
            'duplicateID' => 'Petugas Kebersihan'
        ]);

        //15
        Divisi::create([
            'nama'      => 'Penjaga Sekolah',
            'duplicateID' => 'Penjaga Sekolah'
        ]);

        //16
        Divisi::create([
            'nama'      => 'Satuan Pengamanan',
            'duplicateID' => 'Satuan Pengamanan'
        ]);

        //17
        Divisi::create([
            'nama'      => 'Penjaga Malam',
            'duplicateID' => 'Penjaga Malam'
        ]);

        //18
        Divisi::create([
            'nama'      => 'PLH & Adiwiyata',
            'duplicateID' => 'PLH & Adiwiyata'
        ]);

        //19
        Divisi::create([
            'nama'      => 'Belum Dimasukkan',
            'duplicateID' => 'Belum Dimasukkan'
        ]);

    }
}
