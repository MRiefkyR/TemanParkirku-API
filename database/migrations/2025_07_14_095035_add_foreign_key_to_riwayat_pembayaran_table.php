<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('riwayat_pembayaran', function (Blueprint $table) {
            $table->foreignId('user_id')->change(); // pastikan foreignId
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('riwayat_pembayaran', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
