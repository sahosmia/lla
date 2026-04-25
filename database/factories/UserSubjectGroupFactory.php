<?php

namespace Database\Factories;

use App\Models\SubjectGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSubjectGroup>
 */
class UserSubjectGroupFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'subject_group_id' => rand(1, 5),
        ];
    }
}
