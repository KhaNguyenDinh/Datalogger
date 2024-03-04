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
        Schema::create('khuVuc', function (Blueprint $table) {
            $table->increments('id_khuVuc');
            $table->integer('id_nhaMay')->unsigned();
            $table->foreign('id_nhaMay')->references('id_nhaMay')->on('nhaMay')->onDelete('cascade');
            $table->string('name_khuVuc');
            $table->string('folder_TXT');
            $table->string('type');
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
        Schema::dropIfExists('khuVuc');
    }
}
