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
        $table->string('order_id')->nullable()->after('user_id');
    });
}

public function down()
{
    Schema::table('riwayat_pembayaran', function (Blueprint $table) {
        $table->dropColumn('order_id');
    });
}
};
