<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string("name", 255)->nullable();
            $table->integer("height")->nullable();
            $table->float("mass", 255)->nullable();
            $table->string("hair_color", 55)->nullable();
            $table->string("skin_color", 55)->nullable();
            $table->string("eye_color", 55)->nullable();
            $table->string("birth_year", 55)->nullable();
            $table->string("gender", 55)->nullable();
            $table->string("homeworld", 55)->nullable();
            $table->timestamp("created")->nullable();
            $table->timestamp("edited")->nullable();
            $table->string("url")->nullable();

            // "films": [],
            // "species": [],
            // "vehicles": [],
            // "starships": [],

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
