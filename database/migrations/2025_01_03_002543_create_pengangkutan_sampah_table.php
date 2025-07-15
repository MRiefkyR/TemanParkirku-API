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
    Schema::create('pengangkutan_sampah', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pengguna_id');
        $table->unsignedBigInteger('jadwal_id');
        $table->string('alamat_lengkap');
        $table->timestamps();

        $table->foreign('pengguna_id')->references('id')->on('penggunas')->onDelete('cascade'); // Gunakan nama tabel tanpa 's'
        $table->foreign('jadwal_id')->references('id')->on('jadwal')->onDelete('cascade'); // Gunakan nama tabel tanpa 's'
    });
}


    public function down()
    {
        Schema::dropIfExists('pengangkutan_sampah');
    }
};
