<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Brand;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
        });

        Schema::table('aset', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable()->after('brand');
            $table->foreign('brand_id')->references('id')->on('brand');
        });

        // Pindahkan data brand unik dari aset ke tabel brand
        $existingBrands = DB::table('aset')->distinct()->pluck('brand');

        foreach ($existingBrands as $brandName) {
            $brand = Brand::create(['name' => $brandName]);
            DB::table('aset')->where('brand', $brandName)->update(['brand_id' => $brand->id]);
        }

        // Hapus kolom `brand` dari tabel `aset`
        Schema::table('aset', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }

    public function down()
    {
        // Tambah kembali kolom brand di tabel aset
        Schema::table('aset', function (Blueprint $table) {
            $table->string('brand', 100)->nullable()->after('tanggal_pembelian');
        });

        // Mengembalikan data brand dari tabel brand ke tabel aset
        $asetWithBrands = DB::table('aset')->select('id', 'brand_id')->get();

        foreach ($asetWithBrands as $aset) {
            $brand = Brand::find($aset->brand_id);
            if ($brand) {
                DB::table('aset')->where('id', $aset->id)->update(['brand' => $brand->name]);
            }
        }

        // Hapus kolom brand_id dari tabel aset
        Schema::table('aset', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });

        // Hapus tabel brand
        Schema::dropIfExists('brand');
    }
};
