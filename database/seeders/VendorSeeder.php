<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Vendor::truncate();
        Vendor::create(
            [
                'nama'      => '-',
                'alamat'    => '-',
                'deskripsi' => ''
            ]
        );
    }
}
