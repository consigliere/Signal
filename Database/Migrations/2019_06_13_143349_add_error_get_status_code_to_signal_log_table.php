<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/10/19 4:43 AM
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrorGetStatusCodeToSignalLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signal_log', function(Blueprint $table) {
            $table->string('error_get_status_code')->after('error_uuid')->nullable();
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
            $table->dropColumn('error_get_status_code');
        });
    }
}
