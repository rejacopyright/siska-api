<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('spp', 8, 0)->nullable();
            $table->float('bangunan', 8, 0)->nullable();
            $table->float('seragam', 8, 0)->nullable();
            $table->float('kesiswaan', 8, 0)->nullable();
            $table->float('daftar_ulang', 8, 0)->nullable();
            $table->float('ppdb', 8, 0)->nullable();
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
        Schema::dropIfExists('keuangan_setting');
    }
}
