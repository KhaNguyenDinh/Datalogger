<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camera', function (Blueprint $table) {
            $table->dropForeign(['id_khu_vuc']);
        });
        Schema::table('khuVuc', function (Blueprint $table) {
            $table->dropForeign(['id_nha_may']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('camera', function (Blueprint $table) {
//            $table->foreign('id_khu_vuc')->references('id_khu_vuc')->on('khuVuc')->onDelete('cascade');
//        });
        // code here
    }
}
