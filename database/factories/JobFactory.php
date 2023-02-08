<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'       => fake()->title,
            'description' => fake()->realText,
            'level'       => fake()->randomElement(['Easy', 'Medium', 'Hard']),
            'budget'      => fake()->randomFloat(2, 1,100),
            'address'     => fake()->address,
            'urgency'     => fake()->randomElement(['Very Urgent', 'Urgent', 'Not Urgent']),
            'user_id'     => rand(1, 10),
            'group_id'    => rand(1, 10),
            'winner_id'   => rand(1, 10),
            'status'      => fake()->randomElement(['Done', 'In Progress', 'Bidding']),
        ];
    }
}
