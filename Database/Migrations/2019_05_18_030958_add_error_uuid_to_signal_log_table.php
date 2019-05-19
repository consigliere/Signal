<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/19/19 3:15 PM
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrorUuidToSignalLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signal_log', function(Blueprint $table) {
            $table->string('error_uuid')->after('client_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signal_log', function(Blueprint $table) {
            $table->dropColumn('error_uuid');
        });
    }
}
