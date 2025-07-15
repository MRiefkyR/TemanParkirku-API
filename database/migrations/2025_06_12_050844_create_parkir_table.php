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
        Schema::create('parkir', function (Blueprint $table) {
            $table->id();
            $table->string('no_plat');
            $table->time('jam_masuk');
            $table->string('jenis_kendaraan');
            $table->integer('tarif');
            $table->string('order_id')->unique();
            $table->enum('status', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('parkir');
    }
};
