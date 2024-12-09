<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            'Samsung',
            'Apple',
            'Dell',
            'HP',
            'Lenovo',
            'Asus',
            'Acer',
        ];

        foreach ($brands as $brandName) {
            Brand::create(['name' => $brandName]);
        }
    }
}
