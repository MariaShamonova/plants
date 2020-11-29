<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plant_id')->nullable();
            $table->unsignedInteger('size_id')->nullable();
            $table->unsignedInteger('color_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('count')->nullable();
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
        Schema::dropIfExists('plant_infos');
    }
}