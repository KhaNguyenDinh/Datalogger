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
            $table->integer('id_khu_vuc')->unsigned();
            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuvuc')->onDelete('cascade');
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
