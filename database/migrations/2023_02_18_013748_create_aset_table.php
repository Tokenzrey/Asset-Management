<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 100)->unique();
            $table->string('nama', 100);
            $table->integer('jumlah');
            $table->string('satuan', 100);
            $table->date('tanggal_pembelian');
            // $table->bigInteger('nilai_harga');
            $table->string('brand', 100);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('gambar', 200);
            // $table->date('tanggal_akhir_garansi');
            $table->string('nama_penerima');
            $table->string('tempat', 100);
            $table->string('deskripsi')->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');

            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori');

            $table->unsignedBigInteger('jenis_pemeliharaan_id');
            $table->foreign('jenis_pemeliharaan_id')->references('id')->on('jenis_pemeliharaan');

            $table->unsignedBigInteger('ruang_id');
            $table->foreign('ruang_id')->references('id')->on('ruang');

            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendor');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset');
    }
}
