<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAnswer>
 */
class UserAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => User::inRandomOrder()->first(),
            'id_answer' => Answer::inRandomOrder()->first(),
        ];
    }
}
