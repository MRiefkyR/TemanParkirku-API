<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunasTable extends Migration  // Changed from CreatePenggunasTable
{
    public function up()
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('alamat', 255);
            $table->string('nomor_telepon', 20);
            $table->string('nomor_identitas', 20)->unique();
            $table->date('tanggal_bergabung');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penggunas');
    }
}
