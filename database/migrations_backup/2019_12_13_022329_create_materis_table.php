<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('materi_id')->nullable();
            $table->bigInteger('rpp_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('indikator')->nullable();
            $table->string('metode')->nullable();
            $table->text('sumber')->nullable();
            $table->text('kegiatan')->nullable();
            $table->longtext('materi')->nullable();
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
        Schema::dropIfExists('materi');
    }
}
