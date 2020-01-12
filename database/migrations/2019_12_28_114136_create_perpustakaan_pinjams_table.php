<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpustakaanPinjamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpustakaan_pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pinjam_id')->nullable();
            $table->bigInteger('perpustakaan_id')->nullable();
            $table->bigInteger('siswa_id')->nullable();
            $table->datetime('tgl_pinjam')->nullable();
            $table->datetime('tgl_dikembalikan')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('perpustakaan_pinjam');
    }
}
