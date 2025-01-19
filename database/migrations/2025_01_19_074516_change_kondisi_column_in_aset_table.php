<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeKondisiColumnInAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ubah tipe data kolom kondisi menjadi ENUM
        DB::statement("ALTER TABLE aset MODIFY kondisi ENUM('Baik', 'Rusak Ringan', 'Rusak Berat') NOT NULL");

        // Pastikan semua data dalam kolom kondisi sesuai dengan nilai ENUM yang baru
        DB::table('aset')->get()->each(function ($aset) {
            $validValues = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
            $updatedCondition = in_array($aset->kondisi, $validValues) ? $aset->kondisi : 'Baik'; // Set default jika tidak valid
            DB::table('aset')
                ->where('id', $aset->id)
                ->update(['kondisi' => $updatedCondition]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan tipe data kolom kondisi menjadi VARCHAR
        DB::statement("ALTER TABLE aset MODIFY kondisi VARCHAR(255)");

        // Pastikan semua data tetap ada meskipun kembali ke VARCHAR
        DB::table('aset')->get()->each(function ($aset) {
            $updatedCondition = (string) $aset->kondisi; // Konversi ke string untuk keamanan
            DB::table('aset')
                ->where('id', $aset->id)
                ->update(['kondisi' => $updatedCondition]);
        });
    }
}
