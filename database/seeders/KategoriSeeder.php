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
        $kategoriData = [
            [
                'nama'=>'Bangunan dan Prasarana',
                'masa_manfaat'=>20,
                'kode'=>'BP'
            ],
            [
                'nama'=>'Mesin dan Peralatan',
                'masa_manfaat'=>10,
                'kode'=>'MP'
            ],
            [
                'nama'=>'Kendaraan Bermotor',
                'masa_manfaat'=>5,
                'kode'=>'KB'
            ],
            [
                'nama'=>'Peralatan Kantor',
                'masa_manfaat'=>5,
                'kode'=>'PK'
            ],
        ];
        Schema::disableForeignKeyConstraints();
        Kategori::truncate();
        Kategori::insert($kategoriData);
    }
}
