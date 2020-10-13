<?php

namespace Database\Factories;

use App\Models\category_location;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker,
            'description',
            'image',
            'contact',
            'latitude',
            'longitude',
        ];
    }
}
