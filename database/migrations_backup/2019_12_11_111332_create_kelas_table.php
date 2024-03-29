<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('kelas', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('kelas_id')->nullable();
         $table->bigInteger('wali')->nullable();
         $table->string('nama')->nullable();
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
        Schema::dropIfExists('kelas');
    }
}
