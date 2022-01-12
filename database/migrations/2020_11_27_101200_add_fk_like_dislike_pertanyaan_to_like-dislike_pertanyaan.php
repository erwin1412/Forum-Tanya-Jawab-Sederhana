<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkLikeDislikePertanyaanToLikeDislikePertanyaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('like-dislike_pertanyaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')
            ->references('id_user')->on('users')
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
        Schema::table('like-dislike_pertanyaan', function (Blueprint $table) {
            $table->dropForeign(['id_pertanyaan']);
            $table->dropColumn(['id_pertanyaan']);
           
            $table->dropForeign(['id_user']);
            $table->dropColumn(['id_user']);
        });
    }
}
