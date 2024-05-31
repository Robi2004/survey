<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->lexify('SurTitle-???'),
            'image' => $this->faker->unique()->lexify('SurImage-???'),
            'id_user' => User::inRandomOrder()->first(),
            'locked' => false,
        ];
    }
}
