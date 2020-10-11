<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('articul')->unique();
            $table->string('title');
            $table->double('price');
            $table->unsignedInteger('size_id')->nullable();
            $table->unsignedInteger('color_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->string('description');
            $table->binary('image');
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
        Schema::dropIfExists('plants');
       
        
    }
}
