<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ListLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 5; $i++){
            // insert data ke table user
            DB::table('list_location')->insert([
                'name' => $faker->name,
                'address' => $faker->address,
                'description' => $faker->text($maxNbChars = 200),
                'image' => $faker->imageUrl($width = 640, $height = 480),
                'contact' => $faker->email,
                'tag' => $faker->word,
                'latitude' => $faker->latitude($min = -90, $max = 90) ,
                'longtitude' => $faker->longitude($min = -180, $max = 180)
            ]);
        }  
    }
}
