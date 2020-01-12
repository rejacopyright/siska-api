<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rpp_id')->nullable();
            $table->bigInteger('silabus_id')->nullable();
            $table->text('kd')->nullable();
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
        Schema::dropIfExists('rpp');
    }
}
