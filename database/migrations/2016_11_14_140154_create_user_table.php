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
            $table->primary('id')->increments()->unsigned();
            $table->string('email', 250);
            $table->string('login', 50);
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('password', 250);
            $table->integer('sexe_id')->unsigned();
            $table->foreign('sexe_id')->references('id')->on('sexe');
            $table->integer('orientation_sexe_id')->unsigned();
            $table->foreign('orientation_sexe_id')->references('id')->on('orientation_sexe');
            $table->longText('bio', 500);
            $table->integer('interets')->unsigned();
            $table->foreign('interets')->references('id')->on('user_interets');
            $table->integer('photos')->unsigned();
            $table->foreign('photos')->references('id')->on('user_photos');
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
