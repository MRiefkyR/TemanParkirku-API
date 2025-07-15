<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAdminsTable extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable()->after('email');
            $table->string('agama')->nullable()->after('tanggal_lahir');
            $table->string('nomor_telepon')->nullable()->after('agama');
            $table->text('alamat')->nullable()->after('nomor_telepon');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['tanggal_lahir', 'agama', 'nomor_telepon', 'alamat']);
        });
    }
}
