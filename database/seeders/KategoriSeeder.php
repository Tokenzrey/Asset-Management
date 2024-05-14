<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Kategori::truncate();
        Kategori::create(
            [
                'nama' => 'Belum Terisi',
                'batas_masa_manfaat_tahun' => null
            ]
        );
        Kategori::create(
            [
                'nama' => 'Bangunan dan prasarana',
                'batas_masa_manfaat_tahun' => 20
            ]
        );
        Kategori::create(
            [
                'nama' => 'Mesin dan peralatan',
                'batas_masa_manfaat_tahun' => 10
            ]
        );
        Kategori::create(
            [
                'nama' => 'Kendaraan bermotor',
                'batas_masa_manfaat_tahun' => 5
            ]
        );
        Kategori::create(
            [
                'nama' => 'Peralatan kantor',
                'batas_masa_manfaat_tahun' => 5
            ]
        );
    }
}
