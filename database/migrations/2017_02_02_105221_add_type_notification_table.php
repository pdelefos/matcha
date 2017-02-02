<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_type', function (Blueprint $table) {
            DB::table('notification_type')->insert(['description' => 'like']);
            DB::table('notification_type')->insert(['description' => 'unlike']);
            DB::table('notification_type')->insert(['description' => 'match']);
            DB::table('notification_type')->insert(['description' => 'visit']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_type', function (Blueprint $table) {
            //
        });
    }
}
