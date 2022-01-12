<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkLikeDislikeJawabanToLikeDislikeJawaban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('like-dislike_jawaban', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
            ->references('id_user')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('id_jawaban');
            $table->foreign('id_jawaban')
            ->references('id_jawaban')->on('jawaban')
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
        Schema::table('like-dislike_jawaban', function (Blueprint $table) {
            $table->dropForeign(['id_jawaban']);
            $table->dropColumn(['id_jawaban']);
           
            $table->dropForeign(['id_user']);
            $table->dropColumn(['id_user']);
        });
    }
}
