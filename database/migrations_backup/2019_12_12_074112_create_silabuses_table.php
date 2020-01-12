<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilabusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silabus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('silabus_id')->nullable();
            $table->bigInteger('mapel_id')->nullable();
            $table->bigInteger('kelas_id')->nullable();
            $table->bigInteger('semester_id')->nullable();
            $table->text('sk')->nullable();
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
        Schema::dropIfExists('silabus');
    }
}
