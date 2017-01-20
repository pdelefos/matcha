<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_type', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('description', 50);
            $table->timestamps();
        });
        DB::table('notification_type')->insert(['description' => 'online']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_type');
    }
}
