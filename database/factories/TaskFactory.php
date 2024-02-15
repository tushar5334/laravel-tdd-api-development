<?php

namespace Database\Factories;

use App\Models\Lable;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'todo_list_id' => function () {
                return TodoList::factory()->create()->id;
            },
            'lable_id' => function () {
                return Lable::factory()->create()->id;
            },
        ];
    }
}
