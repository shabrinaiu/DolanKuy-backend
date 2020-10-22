<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifikasiRatingReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rating_reviews', function(Blueprint $table) {
            $table->integer('list_location_id')->after('id');
            $table->index('list_location_id');
            $table->integer('user_id')->after('id');
            $table->index('user_id');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
