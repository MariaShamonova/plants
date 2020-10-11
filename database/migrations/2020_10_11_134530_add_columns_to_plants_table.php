<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//         Schema::table('plants', function (Blueprint $table) {
//             $table->foreign('size_id')->references('id')->on('sizes');
// $table->foreign('color_id')->references('id')->on('colors');
// $table->foreign('category_id')->references('id')->on('categories');
//         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('plants', function (Blueprint $table) {
        //     $table->dropForeign(['size_id']);
        //     $table->dropForeign(['color_id']);
        //     $table->dropForeign(['category_id']);
        // });
    }
}
