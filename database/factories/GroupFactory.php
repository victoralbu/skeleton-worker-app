<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => fake()->name(),
            'description' => fake()->text(20),
            'admin_id'    => fake()->numberBetween(1, 10),
            'members_nr'  => fake()->numberBetween(1, 10),
            'invite_code' => fake()->unique()->text(20),
        ];
    }
}
