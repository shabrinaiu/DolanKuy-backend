<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RatingReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 20; $i++){
            // insert data ke table user
            DB::table('rating_review')->insert([
                'rating' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'review' => $faker->text($maxNbChars = 200)
            ]);
        }  
    }
}
