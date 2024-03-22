<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camera', function (Blueprint $table) {
            $table->increments('id_camera');
            $table->integer('id_khuVuc')->unsigned();
            $table->foreign('id_khuVuc')->references('id_khuVuc')->on('khuVuc')->onDelete('cascade');
            $table->string('name_camera');
            $table->string('link_rtsp');
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
        Schema::dropIfExists('camera');
    }
}
