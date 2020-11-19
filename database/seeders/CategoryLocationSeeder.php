<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryLocations;
use Faker\Factory as Faker;

class CategoryLocationSeeder extends Seeder
{
    
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 5; $i++){
            // insert data ke table user
            CategoryLocations::create([
                'name' => $faker->name
            ]);
        }  
    }
}
