<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrientationSexeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientation_sexe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('description', 50);
            $table->timestamps();
        });

        DB::table('orientation_sexe')->insert(['description' => 'homme']);
        DB::table('orientation_sexe')->insert(['description' => 'femme']);
        DB::table('orientation_sexe')->insert(['description' => 'indifferent']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orientation_sexe');
    }
}
