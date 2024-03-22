<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhuVuc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khuvuc', function (Blueprint $table) {
            $table->increments('id_khu_vuc');
            $table->integer('id_nha_may')->unsigned();
            $table->foreign('id_nha_may')->references('id_nha_may')->on('nhamay')->onDelete('cascade');
            $table->string('name_khu_vuc');
            $table->string('folder_txt');
            $table->string('type');
            $table->string('loai');
            $table->longText('link_map');
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
        Schema::dropIfExists('khuvuc');
    }
}
