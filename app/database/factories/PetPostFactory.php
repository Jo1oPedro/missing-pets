<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PetPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'user_id' => User::select('id')->inRandomOrder()->first()->id,
            'coordinate_x' => random_int(0, 10000),
            'coordinate_y' => random_int(0, 10000),
            'breed' => fake()->name(),
            'type' => fake()->text(100),
            'additional_info' => fake()->text(100)
        ];
    }
}
