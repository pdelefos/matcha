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
            $table->string('email', 250);
            $table->string('login', 50);
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('password', 250);
            $table->boolean('completed')->default(false);
            $table->integer('sexe_id')->unsigned()->nullable();
            $table->foreign('sexe_id')->references('id')->on('sexe');
            $table->integer('orientation_sexe_id')->unsigned()->nullable();
            $table->foreign('orientation_sexe_id')->references('id')->on('orientation_sexe');
            $table->dateTime('anniversaire')->nullable();
            $table->string('localisation', 250)->nullable();
            $table->integer('latitude')->unsigned()->nullable();
            $table->integer('longitude')->unsigned()->nullable();
            $table->longText('presentation', 500)->nullable();
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
