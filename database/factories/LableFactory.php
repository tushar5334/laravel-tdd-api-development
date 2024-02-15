<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(3),
            'color' => $this->faker->colorName,
            'user_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
