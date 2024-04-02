<?php

namespace Database\Factories;

use App\Models\Marker;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Marker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->sentence,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
        ];
    }
}
