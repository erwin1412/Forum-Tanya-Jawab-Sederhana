<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkTblPertanyaanDibuatToPertanyaanDibuat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pertanyaan_dibuat', function (Blueprint $table) {
            $table->unsignedBigInteger('id_materi');
            $table->foreign('id_materi')
            ->references('id_materi')->on('materi')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('id_pertanyaan');
            $table->foreign('id_pertanyaan')
            ->references('id_pertanyaan')->on('pertanyaan')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pertanyaan_dibuat', function (Blueprint $table) {
            $table->dropForeign(['id_pertanyaan']);
            $table->dropColumn(['id_pertanyaan']);
           
            $table->dropForeign(['id_materi']);
            $table->dropColumn(['id_materi']);
        });
    }
}
