<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampahTable extends Migration
{
    public function up()
    {
        Schema::create('sampah', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['anorganik', 'organik', 'berbahaya']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sampah');
    }
}
