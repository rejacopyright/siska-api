<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpustakaanSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('perpustakaan_setting', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->double('harga')->nullable();
         $table->integer('durasi')->nullable();
         $table->double('denda_terlambat')->nullable();
         $table->double('denda_rusak')->nullable();
         $table->double('denda_hilang')->nullable();
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
        Schema::dropIfExists('perpustakaan_setting');
    }
}
