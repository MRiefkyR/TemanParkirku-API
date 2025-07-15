<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastActivityToPenggunasTable extends Migration
{
    public function up()
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->timestamp('last_activity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('penggunas', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
}
