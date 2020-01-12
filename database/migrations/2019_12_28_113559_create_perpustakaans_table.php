<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpustakaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpustakaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('perpustakaan_id')->nullable();
            $table->bigInteger('kategori_id')->nullable();
            $table->bigInteger('koleksi_id')->nullable();
            $table->bigInteger('penerbit_id')->nullable();
            $table->string('judul')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('pengarang')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('sumber')->nullable();
            $table->string('img')->nullable();
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
        Schema::dropIfExists('perpustakaan');
    }
}
