<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInteretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_interets', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('interets_id')->unsigned();
            $table->primary(['user_id', 'interets_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_interets');
    }
}
