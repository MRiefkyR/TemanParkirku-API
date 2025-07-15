<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanduanTable extends Migration
{
    public function up()
    {
        Schema::create('panduan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->text('cara');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('panduan');
    }
}
