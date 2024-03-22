<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert', function (Blueprint $table) {
            $table->increments('id_alert');
            $table->integer('id_khu_vuc')->unsigned();
            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuvuc')->onDelete('cascade');
            $table->string('name_alert');
            $table->float ('minmin');
            $table->float ('min');
            $table->float ('max');
            $table->float ('maxmax');
            $table->string('enable');
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
        Schema::dropIfExists('alert');
    }
}
