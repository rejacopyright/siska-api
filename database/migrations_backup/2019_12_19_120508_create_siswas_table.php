<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('siswa', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('siswa_id')->nullable();
         $table->bigInteger('kelas_id')->nullable();
         $table->string('nis')->nullable();
         $table->string('password')->nullable();
         $table->string('api_token')->nullable();
         $table->string('nama')->nullable();
         $table->integer('nik')->nullable();
         $table->integer('kk')->nullable();
         $table->datetime('lahir')->nullable();
         $table->text('alamat')->nullable();
         $table->integer('gender')->nullable();
         $table->string('avatar')->nullable();
         $table->string('wali_status')->nullable();
         $table->string('wali_nama')->nullable();
         $table->string('wali_tlp')->nullable();
         $table->string('wali_email')->nullable();
         $table->text('catatan')->nullable();
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
        Schema::dropIfExists('siswa');
    }
}
