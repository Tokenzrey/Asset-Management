<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeNoTeleponToVarcharInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ubah tipe data kolom no_telepon menjadi VARCHAR
        DB::statement('ALTER TABLE users MODIFY no_telepon VARCHAR(20)');

        // Pastikan semua data dalam kolom no_telepon sesuai dengan tipe VARCHAR
        DB::table('users')->get()->each(function ($user) {
            $formattedPhone = (string) $user->no_telepon; // Konversi ke string
            DB::table('users')
                ->where('id', $user->id)
                ->update(['no_telepon' => $formattedPhone]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan tipe data kolom no_telepon menjadi BIGINT
        DB::statement('ALTER TABLE users MODIFY no_telepon BIGINT');

        // Pastikan semua data dalam kolom no_telepon dapat dikonversi kembali ke BIGINT jika diperlukan
        DB::table('users')->get()->each(function ($user) {
            $formattedPhone = (int) $user->no_telepon; // Konversi kembali ke integer
            DB::table('users')
                ->where('id', $user->id)
                ->update(['no_telepon' => $formattedPhone]);
        });
    }
}
