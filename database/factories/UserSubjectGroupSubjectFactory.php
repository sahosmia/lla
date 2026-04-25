<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSubjectGroupSubject>
 */
class UserSubjectGroupSubjectFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'subject_id' => fake()->randomNumber(Subject::min('id'), Subject::max('id')),
            'hour_rate' => rand(0, 99),
            'description' => fake()->paragraph()
        ];
    }
}
