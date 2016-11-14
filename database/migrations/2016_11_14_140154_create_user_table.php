<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('login', 50)->unique();
            $table->string('email', 255)->unique();
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->integer('sexe_id')->unsigned();
            // $table->foreign('sexe_id')->references('id')->on('sexe');
            $table->integer('orientation_sexe_id')->unsigned();
            // $table->foreign('orientation_sexe_id')->references('id')->on('orientation_sexe');
            $table->string('bio', 500);
            $table->integer('interets_id')->unsigned();
            // $table->foreign('interets_id')->references('id')->on('interet');
            $table->integer('images')->unsigned();
            $table->string('localisation');
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
        Schema::drop('user');
    }
}
