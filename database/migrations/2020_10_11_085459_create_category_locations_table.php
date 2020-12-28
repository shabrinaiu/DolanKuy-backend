<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamps();
        });

        DB::table('category_locations')->insert(
            array(
                'name' => 'Wisata',
            )
        );

        DB::table('category_locations')->insert(
            array(
                'name' => 'Kuliner',
            )
        );

        DB::table('category_locations')->insert(
            array(
                'name' => 'Tempat Ibadah',
            )
        );

        DB::table('category_locations')->insert(
            array(
                'name' => 'Market',
            )
        );

        DB::table('category_locations')->insert(
            array(
                'name' => 'SPBU',
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_locations');
    }
}
