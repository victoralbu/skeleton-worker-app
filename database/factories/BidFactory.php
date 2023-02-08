<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'job_id' => rand(1,10),
            'user_id' => rand(1,10),
            'date' => now(),
            'money' => fake()->randomFloat(2,1,100),
            'few_words' => fake()->realText,
            'status' => fake()->randomElement(['Won', 'In Progress', 'Lost']),
        ];
    }
}
