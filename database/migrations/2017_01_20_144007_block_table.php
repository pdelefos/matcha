<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_table', function (Blueprint $table) {
            $table->integer('asking_id')->unsigned();
            $table->foreign('asking_id')->references('id')->on('user');
            $table->integer('blocked_id')->unsigned();
            $table->foreign('blocked_id')->references('id')->on('user');
            $table->primary(['asking_id', 'blocked_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('block_table');
    }
}
