<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name", 100)->nullable();
            $table->string("rotation_period", 100)->nullable();
            $table->string("orbital_period", 100)->nullable();
            $table->string("diameter", 100)->nullable();
            $table->string("climate", 100)->nullable();
            $table->string("gravity", 100)->nullable();
            $table->string("terrain", 100)->nullable();
            $table->string("surface_water", 100)->nullable();
            $table->string("population", 100)->nullable();
            $table->dateTime("created")->nullable();
            $table->dateTime("edited")->nullable();
            $table->string("url");
            // "residents": [],
            // "films": [],
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planets');
    }
}
