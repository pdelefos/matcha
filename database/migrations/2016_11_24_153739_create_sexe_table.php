<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSexeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sexe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('description', 50);
            $table->timestamps();
        });

        DB::table('sexe')->insert(['description' => 'homme']);
        DB::table('sexe')->insert(['description' => 'femme']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sexe');
    }
}
